<x-home-sections header="Mobizilla AI Assistant">
    <div x-data="AiChatInit()" class="bg-[#0099D9] bg-opacity-25 py-2 px-0 md:p-4 md:grid md:grid-cols-[30%_1fr_30%] max-w-full mt-8">
        <div class="hidden md:flex md:flex-col md:justify-end">
            <img class="object-contain md:block hidden mx-auto mb-4 h-[28rem]"
                src="{{asset('assets/images/iphone.png')}}" alt="" />
        </div>

        <div class="max-h-full flex flex-col justify-end max-w-4xl">
            <div class="mb-2 space-y-4 ai_chat_container min-h-[20vh] max-h-[40vh] overflow-y-hidden" id="ai_chat_container">
                <template x-for="(message, index) in messages" :key="index">
                    <div class="chatRecord w-full flex" :data-role="message.role">
                        <p x-text="message.content"></p>
                    </div>
                </template>

                <template x-if="loading">
                    <div class="chatRecord w-full flex">
                        <p>Loading...</p>
                    </div>
                </template>
            </div>

            <form @submit.prevent="sendMessage" class="w-full z-10">
                <div class="relative">
                    <textarea
                        class="w-full md:m-2 py-2 px-4 mr-1 bg-white rounded-full border border-gray-300 resize-none"
                        rows="1"
                        x-model="messageInput"
                        placeholder="Type your message..."
                        style="outline: none;"
                        @keydown.enter.prevent="sendMessage"></textarea>

                    <button type="submit"
                            class="bg-gray-200 border border-gray-600 rounded-full p-2 absolute right-0 top-0 translate-y-1 md:translate-y-3 -translate-x-1"
                            :disabled="loading">
                        <x-bi-send-fill class="text-gray-600 w-4 h-4"/>
                    </button>
                </div>
            </form>
        </div>

        <div class="max-h-full">
            <img class="object-contain md:block hidden h-full"
                 src="{{asset('assets/images/ai-chat.png')}}" alt="" />
        </div>
    </div>
</x-home-sections>

@push('js')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('AiChatInit', () => ({
                messages: @json($this->messages), // Initial messages
                messageInput: '', // User input
                loading: false,

                async sendMessage() {
                    if (!this.messageInput.trim() || this.loading) return;

                    // Add user's message
                    this.messages.push({ content: this.messageInput, role: 'user' });

                    // Clear input & set loading
                    let userMessage = this.messageInput;
                    this.messageInput = '';
                    this.loading = true;
                    this.scrollToBottom();

                    // Get Livewire instance
                    let $wire = @this;

                    // Send message to Livewire & fetch updated messages
                    const response = await $wire.sendMessage(userMessage);
                    const updatedMessages = await $wire.getMessages(); // Fetch new messages

                    // Update messages reactively
                    this.messages = updatedMessages;
                    this.scrollToBottom();
                    this.loading = false;
                },
                scrollToBottom() {
                    this.$nextTick(() => {
                        let container = document.getElementById('ai_chat_container');
                        container.scrollTop = container.scrollHeight;
                    });
                },
                init() {
                    this.$nextTick(() => {
                        let container = document.getElementById('ai_chat_container');
                        container.scrollTop = container.scrollHeight;
                    });
                },
            }));
        });
    </script>
@endpush
