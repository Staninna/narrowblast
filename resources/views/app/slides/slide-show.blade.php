<x-common-layout>
    <div class="reveal">
        <div class="slides" id="slideContainer">
            <section role="status" data-background-gradient="linear-gradient(to bottom right, #2D4747, #000000)">
                <div class="grid place-items-center w-full h-full gap-2">
                    <svg aria-hidden="true" class="inline w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="text-sm">Loading...</span>
                </div>
            </section>
        </div>
    </div>

    @include('app.slides.slide-creator')

    @include('app.slides.iframe-scripts')

    <script>
        const tickUrl = `{{ route('slides.slideShowTick', $screen) }}`;
        let hasLoaded = false;

        function updateSlideChanges(slides) {
            const slideEls = getSlideContainer().querySelectorAll('section[data-background-iframe]');
            let madeChanges = false;

            for (const slideEl of slideEls) {
                const publicPath = slideEl.getAttribute('data-background-iframe');
                const slideDataIndex = slides.findIndex(slide => slide.publicPath === publicPath);

                if (slideDataIndex === -1) {
                    slideEl.remove();
                    madeChanges = true;
                }
            }

            for (const slide of slides) {
                if (!findSlideByPublicPath(slide.publicPath)) {
                    addSlide(slide);
                    madeChanges = true;
                }
            }

            if (madeChanges) {
                window.RevealDeck.sync();

                // For some reason, sync doesn't always work the first time
                setTimeout(() => {
                    window.RevealDeck.sync();
                }, 250);
            }
        }

        function doTick(secretTickKey) {
            fetch(tickUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Secret-Tick-Key': secretTickKey,
                    'X-CSRF-TOKEN': latestCsrfToken
                },
                body: JSON.stringify({
                    'screen_id': {{ $screen->id }},
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);

                if(data.error && data.error.indexOf('secret') > -1) {
                    localStorage.removeItem('secretTickKey');
                    window.location.reload();
                    return;
                }

                if(!hasLoaded) {
                    hasLoaded = true;
                    window.clearSlides();
                }

                updateSlideChanges(data.slides);

                latestCsrfToken = data.csrfToken;
            })
            .catch(error => {
                console.error(error);
            });
        }

        let secretTickKey = "{{ config('app.slide_show_secret_tick_key') }}";

        function setup(secretTickKey) {
            doTick(secretTickKey);
            setInterval(function() {
                doTick(secretTickKey);
            }, {{ config('app.slide_show_tick_interval_in_seconds') * 1000 }});
        }

        setup(secretTickKey);

    </script>
</x-common-layout>
