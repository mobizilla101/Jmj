<?php

namespace App\Models;

use App\CartFormatters\AccessoriesFormatter;
use App\CartFormatters\MachineryFormatter;
use App\CartFormatters\SecondhandInventoriesFormatter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory;

    protected $guarded = [];
    protected $casts = ['extra' => 'array'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($item) {
            if (Auth::check()) {
                $existingItem = self::where('item_id', $item->item_id)
                    ->where('item_type', $item->item_type)
                    ->where('extra', $item->extra)
                    ->where('user_id', auth()->id())
                    ->first();

                if ($existingItem) {
                    $existingItem->increment('quantity', $item->quantity ?? 1);
                    return null;
                }
            }
        });
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }

    public static function addItem(array $data)
    {
        if (Auth::check()) {
            return self::create([
                'user_id' => auth()->id(),
                'item_id' => $data['id'],
                'item_type' => $data['item_type'],
                'extra' => $data['extra'] ?? null,
                'amount' => $data['amount'] ?? 0,
                'discount' => $data['discount'] ?? 0,
                'quantity' => $data['quantity'] ?? 1,
            ]);
        }

        // Session-based cart for guests
        $cart = session()->get('cart', []);
        $Id = $data['id'];

        if (isset($cart[$Id])) {
            $cart[$Id]['quantity'] += $data['quantity'] ?? 1;
        } else {
            $cart[$Id] = [
                'item_id' => $data['id'],
                'item_type' => $data['item_type'],
                'extra' => $data['extra'],
                'amount' => $data['amount'] ?? 0,
                'discount' => $data['discount'] ?? 0,
                'quantity' => $data['quantity'] ?? 1,
            ];
        }

        session()->put('cart', $cart);
        return collect($cart);
    }

    public static function getCartItems(): \Illuminate\Support\Collection|Collection

    {
        if (Auth::check()) {

// Get the user's cart items from the database
            $dbCartItems = self::with('item')->where('user_id', auth()->id())->get();
// Check if there's a session cart
            $sessionCart = session()->get('cart', []);
            if (!empty($sessionCart)) {
// Merge session cart into database
                foreach ($sessionCart as $sessionItem) {
// Check if item exists in the database cart
                    $existingItem = $dbCartItems->firstWhere('item_id', $sessionItem['item_id']);
                    if ($existingItem) {
// Update quantit
                        $existingItem->quantity += $sessionItem['quantity'];
                        $existingItem->discount = $sessionItem['discount'] ?? $existingItem->discount;
                        $existingItem->amount = $sessionItem['amount'] ?? $existingItem->amount;
                        $existingItem->save();
                    } else {
// Create new cart item
                        self::create([
                            'user_id' => auth()->id(),
                            'item_id' => $sessionItem['item_id'],
                            'item_type' => $sessionItem['item_type'],
                            'amount'=>$sessionItem['amount'] ?? 0,
                            'discount'=>$sessionItem['discount'] ?? 0,
                            'extra' => $sessionItem['extra'] ?? null,
                            'quantity' => $sessionItem['quantity'],
                        ]);

                    }

                }
// Clear the session cart after merging
                session()->forget('cart');
            }
// Now, get the updated cart items from the database
            $cartItems = self::with('item')->where('user_id', auth()->id())->get();
        } else {
            $cartItems = collect(session()->get('cart', []));
        }

        return $cartItems->map(fn($cartItem) => self::formatCartItem($cartItem));

    }

    private static function formatCartItem($cartItem): array
    {
        $formatter = self::getFormatterForItemType($cartItem['item_type']);

        return $formatter ? $formatter::format($cartItem) : [];
    }

    private static function getFormatterForItemType($itemType): ?string
    {
        $formatters = [
            Sku::class => \App\CartFormatters\SkuFormatter::class,
            SecondhandInventory::class => SecondhandInventoriesFormatter::class,
            Parts::class => \App\CartFormatters\PartsFormatter::class,
            Machinery::class => \App\CartFormatters\MachineryFormatter::class,
            Accessory::class => AccessoriesFormatter::class
            // Add other item types here
        ];

        return $formatters[$itemType] ?? null;
    }

    public static function checkInventoryInCart($data): bool
    {
        if (Auth::check()) {
            return self::where('item_id', $data['item_id'])
                ->where('item_type', $data['item_type']) // Ensure correct morph type
                ->where('extra', $data['extra'])
                ->with('item') // Load the actual item
                ->exists();
        }

        // If using session-based cart, manually check for the item
        $cart = session()->get('cart', []);
        foreach ($cart as $item) {
            if (
                $item['item_id'] == $data['item_id']
                && $item['item_type'] == $data['item_type']
                && $item['extra'] == $data['extra']
            ) {
                return true; // Return the specific item found  in the cart
            }
        }

        return false; // Item not found
    }


    public function item()
    {
        return $this->morphTo();
    }

    public static function removeItem($item_type, $item_id)
    {
        if (Auth::check()) {
            // Remove the item from the database for authenticated users
            self::where('item_id', $item_id)
                ->where('item_type', $item_type)
                ->where('user_id', auth()->id())
                ->delete();
        } else {
            // Remove the item from the session for guest users
            $cart = session()->get('cart', []);

            foreach ($cart as $key => $item) {
                if ($item['item_id'] == $item_id && $item['item_type'] == $item_type) {
                    unset($cart[$key]);
                    break;
                }
            }

            session()->put('cart', $cart);
        }
        return true;
    }

    public static function findCart($item_type, $item_id)
    {
        if (!Auth::check()) {
            $cart = collect(session()->get('cart', []));

            $cartItem = $cart->first(function ($item) use ($item_type, $item_id) {
                return $item['item_type'] === $item_type && $item['item_id'] == $item_id;
            });

            return $cartItem ? self::formatCartItem($cartItem) : null;
        }

        $cartItem = self::where('item_type', $item_type)
            ->where('item_id', $item_id)
            ->first();

        return $cartItem ? self::formatCartItem($cartItem) : null;
    }

    public static function increaseQuantity(string $item_type, int $item_id): void
    {
        if (Auth::check()) {
            $cartItem = self::where('item_type', $item_type)
                ->where('item_id', $item_id)
                ->where('user_id', auth()->id())
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity');
            }
        } else {
            $cart = session()->get('cart', []);

            foreach ($cart as $key => $item) {
                if ($item['item_type'] === $item_type && $item['item_id'] == $item_id) {
                    $cart[$key]['quantity']++;
                    break;
                }
            }

            session()->put('cart', $cart);
        }
    }

    public static function decreaseQuantity(string $item_type, int $item_id): void
    {
        if (Auth::check()) {
            $cartItem = self::where('item_type', $item_type)
                ->where('item_id', $item_id)
                ->where('user_id', auth()->id())
                ->first();

            if ($cartItem) {
                if ($cartItem->quantity > 1) {
                    $cartItem->decrement('quantity');
                }
            }
        } else {
            $cart = session()->get('cart', []);

            foreach ($cart as $key => $item) {
                if ($item['item_type'] === $item_type && $item['item_id'] == $item_id) {
                    if ($cart[$key]['quantity'] > 1) {
                        $cart[$key]['quantity']--;
                    }
                    break;
                }
            }

            session()->put('cart', $cart);
        }
    }

    public static function hasInCart(Model $model, array $extra = null): bool
    {
        $item_type = get_class($model);
        $item_id = $model->id;

        if (Auth::check()) {
            return self::where('item_type', $item_type)
                ->where('item_id', $item_id)
                ->when($extra, fn($query) => $query->where('extra', json_encode($extra)))
                ->where('user_id', auth()->id())
                ->exists();
        }

        $cart = session()->get('cart', []);

        foreach ($cart as $item) {
            if (
                $item['item_type'] === $item_type &&
                $item['item_id'] == $item_id &&
                ($extra ? $item['extra'] == $extra : true)
            ) {
                return true;
            }
        }

        return false;
    }

    public static function clear(){
        self::where('user_id', auth()->id())->delete();
    }

}
