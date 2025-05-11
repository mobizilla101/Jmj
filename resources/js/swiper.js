import Swiper from "swiper/bundle";
import 'swiper/css/bundle';
import {Navigation, Pagination} from "swiper/modules";

window.Swiper = Swiper;
window.Navigation = Navigation;
window.Pagination = Pagination;


document.addEventListener('DOMContentLoaded', function () {
    const videoElement = document.querySelector('.videoSwiper');
    if (videoElement) {
        const initial = Math.floor(videoElement.querySelector('.swiper-wrapper').children.length / 2)

        const videoSwiper = new Swiper('.videoSwiper', {
            effect: 'coverflow',
            grabCursor: true,
            loop: false,
            // spaceBetween: 30,
            centeredSlides: true,
            preventClicks: true,
            initialSlide: initial,
            speed: 600,
            slidesPerView: 'auto',
            autoplay: false,
            coverflowEffect: {
                rotate: 0,
                stretch: 80,
                depth: 350,
                modifier: 1,
                slideShadows: true,
            },
            on: {
                click(event) {
                    videoSwiper.slideTo(this.clickedIndex);
                },
            }
        });
    }
})


const productAttachmentSwiper = new Swiper('.product_attachment_swiper', {
    modules: [Navigation, Pagination],
    navigation: {
        prevEl: '.product_attachment_swiper-button-prev',
        nextEl: '.product_attachment_swiper-button-next',
    },
    grabCursor: true,
    loop: false,
    spaceBetween: 20,
    breakpoints: {
        640: {
            direction: 'vertical'
        },
    },
    direction: 'horizontal',
    centeredSlides: false,
    preventClicks: true,
    initialSlide: 0,
    speed: 600,
    slidesPerView: 3,
    autoplay: false,
    on: {
        click(event) {
            const clickedIndex = this.clickedIndex;
            if (clickedIndex !== undefined) {
                this.slideTo(clickedIndex);

                this.slides.forEach(slide => {
                    slide.classList.remove('swiper-slide-active');
                });
                this.slides[clickedIndex].classList.add('swiper-slide-active');
            }
        },
    }
});

const bannerLeftSwiper = new Swiper('.banner-left-swiper', {
    speed: 600,
    loop: true,
    autoplay: true
});

const bannerRightSwiper = new Swiper('.banner-right-swiper', {
    speed: 600,
    loop: true,
    autoplay: {
        delay: 5000,
        reverseDirection: true
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const check = document.querySelector('.product_swiper_element');
    if (check) {
        const product_swiper = new Swiper('.product_swiper_element', {
            modules: [Navigation, Pagination],
            speed: 5000,
            spaceBetween: 20,
            autoplay: {
                delay: 0,
                pauseOnMouseEnter: true,
            },
            loop: true,
            slidesPerView: 2,
            slidesPerGroup: 1,
            grabCursor: true,
            breakpoints: {
                640: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                1024: {
                    slidesPerView: 5,
                },
                1440: {
                    slidesPerView: 6,
                }
            },
            navigation: {
                prevEl: ".product-btn-prev",
                nextEl: ".product-btn-next"
            }

        })
    }
})

document.addEventListener('DOMContentLoaded', function () {
    const check = document.querySelector('.hotaccessories_swiper_element');
    if (check) {
        const hotaccessories_swiper = new Swiper('.hotaccessories_swiper_element', {
            modules: [Navigation, Pagination],
            speed: 5000,
            spaceBetween: 20,
            autoplay: {
                delay: 0,
                pauseOnMouseEnter: true,
            },
            loop: true,
            slidesPerView: 2,
            slidesPerGroup: 1,
            grabCursor: true,
            breakpoints: {
                640: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                1024: {
                    slidesPerView: 5,
                },
                1440: {
                    slidesPerView: 6,
                }
            },
            navigation: {
                prevEl: ".accessories-product-btn-prev",
                nextEl: ".accessories-product-btn-next"
            }

        })
    }
})

document.addEventListener('DOMContentLoaded', function () {
    const check = document.querySelector('.hotparts_swiper_element');
    if (check) {
        const hotparts_swiper = new Swiper('.hotparts_swiper_element', {
            modules: [Navigation, Pagination],
            speed: 5000,
            spaceBetween: 20,
            autoplay: {
                delay: 0,
                pauseOnMouseEnter: true,
            },
            loop: true,
            slidesPerView: 2,
            slidesPerGroup: 1,
            grabCursor: true,
            breakpoints: {
                640: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                1024: {
                    slidesPerView: 5,
                },
                1440: {
                    slidesPerView: 6,
                }
            },
            navigation: {
                prevEl: ".parts-product-btn-prev",
                nextEl: ".parts-product-btn-next"
            }

        })
    }
})

document.addEventListener('DOMContentLoaded', function () {
    const check = document.querySelector('.hotmachine_swiper_element');
    if (check) {
        const hotmachine_swiper = new Swiper('.hotmachine_swiper_element', {
            modules: [Navigation, Pagination],
            speed: 5000,
            spaceBetween: 20,
            autoplay: {
                delay: 0,
                pauseOnMouseEnter: true,
            },
            loop: true,
            slidesPerView: 2,
            slidesPerGroup: 1,
            grabCursor: true,
            breakpoints: {
                640: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                1024: {
                    slidesPerView: 5,
                },
                1440: {
                    slidesPerView: 6,
                }
            },
            navigation: {
                prevEl: ".machine-product-btn-prev",
                nextEl: ".machine-product-btn-next"
            }

        })
    }
})

document.addEventListener('DOMContentLoaded', function () {
    let check = document.getElementsByClassName('.review_swiper');
    if (check) {
        const reviewSwiper = new Swiper('.review_swiper', {
            speed: 1000,
            slidesPerView: 1,
            slidesPerGroup: 1,
            spaceBetween: 30,
            autoplay: {
                delay: 3000,
                pauseOnMouseEnter: true,
            },
            loop: true,
            breakpoints: {
                425: {
                    slidesPerView: 2,
                },
                640: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                }
            },
            grabCursor: true,
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    let check = document.getElementsByClassName('.poweredby_swiper');
    if (check) {
        const clientSwiper = new Swiper('.poweredby_swiper', {
            speed: 5000,
            autoplay: {
                delay: 0,
                pauseOnMouseEnter: true,
            },
            loop: true,
            slidesPerView: 2,
            slidesPerGroup: 1,
            spaceBetween: 25,
            breakpoints: {
                640: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                1024: {
                    slidesPerView: 5,
                },
                1440: {
                    slidesPerView: 6,
                }
            },
            grabCursor: true
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    let check = document.getElementsByClassName('.brand_swiper');
    if (check) {
        const brandSwiper = new Swiper('.brand_swiper', {
            speed: 5000,
            autoplay: {
                delay: 0,
                pauseOnMouseEnter: true,
            },
            slidesPerView: 3,
            slidesPerGroup: 1,
            spaceBetween: 20,
            loop: true,
            breakpoints: {
                425: {
                    slidesPerView: 4,
                },
                640: {
                    slidesPerView: 5,
                },
                1024: {
                    slidesPerView: 7,
                }
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    let check = document.getElementsByClassName('.machine-working-swiper');
    if (check) {
        const partsBrandSwiper = new Swiper('.machine-working-swiper', {
            modules: [Navigation, Pagination],
            navigation: {
                prevEl: '.machine-button-prev',
                nextEl: '.machine-button-next',
            },
            speed: 1000,
            slidesPerView: 2,
            slidesPerGroup: 1,
            spaceBetween: 20,
            breakpoints: {
                640: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                    slidesPerGroup: 2,
                },
                1024: {
                    slidesPerView: 6,
                    slidesPerGroup: 3,
                }
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    let check = document.getElementsByClassName('.category_swiper');
    if (check) {
        const modelSwiper = new Swiper('.category_swiper', {
            modules: [Navigation, Pagination],
            navigation: {
                prevEl: '.category-button-prev',
                nextEl: '.category-button-next',
            },
            speed: 1000,
            slidesPerView: 2,
            slidesPerGroup: 1,
            spaceBetween: 20,
            breakpoints: {
                640: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                    slidesPerGroup: 2,
                },
                1024: {
                    slidesPerView: 6,
                    slidesPerGroup: 3,
                }
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    let check = document.getElementsByClassName('.related_swiper');
    if (check) {
        const relatedSwiper = new Swiper('.related_swiper', {
            modules: [Navigation, Pagination],
            navigation: {
                prevEl: '.related_swiper-button-prev',
                nextEl: '.related_swiper-button-next',
            },
            speed: 1000,
            slidesPerView: 2,
            slidesPerGroup: 1,
            spaceBetween: 20,
            breakpoints: {
                768: {
                    slidesPerView: 4,
                    slidesPerGroup: 1,
                },
                1440: {
                    slidesPerView: 5,
                    slidesPerGroup: 2,
                }
            }
        });
    }
});
