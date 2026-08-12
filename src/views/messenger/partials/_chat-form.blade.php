<form id="chat-form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="chat_id" id="chat_id">
    <input type="hidden" name="receiver_id" id="receiver_id">
    <input type="hidden" name="receiver_type" id="receiver_type">
    <div class="messenger-row messenger-g-0 messenger-align-items-center">
        <div class="messenger-file_Upload">
            <div class="messenger-profile-media-img messenger-image_pre"></div>
        </div>
        <div class="messenger-col-auto">
            <div class="messenger-chat-input-links messenger-me-md-2">
                <div class="messenger-links-list-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                     data-bs-placement="top" aria-label="More" data-bs-original-title="More">

                    <a class="messenger-btn messenger-btn-link messenger-text-decoration-none messenger-btn-lg messenger-waves-effect messenger-collapsed"
                       data-bs-toggle="collapse" data-bs-target="#chatinputmorecollapse"
                       aria-expanded="false" aria-controls="chatinputmorecollapse">
                        <i class="bx bx-dots-horizontal-rounded messenger-align-middle"></i>
                    </a>
                </div>
                <div class="messenger-links-list-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                     data-bs-placement="top" aria-label="Emoji" data-bs-original-title="Emoji">
                    <a class="messenger-btn messenger-btn-link messenger-text-decoration-none messenger-btn-lg messenger-waves-effect messenger-emoji-btn" id="emoji-btn">
                        <i class="bx bx-smile messenger-align-middle"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="messenger-col">
            <div class="messenger-position-relative">
                <div class="messenger-chat-input-feedback">
                    Please Enter a Message
                </div>
                <input autocomplete="off" type="text" name="message"
                       class="messenger-form-control messenger-bg-light messenger-border-0 messenger-chat-input"
                       id="chat-input" placeholder="Type your message...">
                {{--<div class="chat-input-typing">--}}
                {{--<span class="typing-user d-flex">--}}
                {{--Victoria Lane is typing--}}
                {{--<span class="typing ms-2">--}}
                {{--<span class="dot"></span>--}}
                {{--<span class="dot"></span>--}}
                {{--<span class="dot"></span>--}}
                {{--</span>--}}
                {{--</span>--}}
                {{--</div>--}}
            </div>
        </div>

        @include('messenger::partials._image-gallery')

        <div class="messenger-col-auto">
            <div class="messenger-chat-input-links messenger-ms-2 messenger-gap-md-1">
                <div class="messenger-links-list-item">
                    <button class="messenger-btn messenger-btn-primary messenger-btn-lg messenger-chat-send messenger-waves-effect messenger-waves-light">
                        <i class="bx bxs-send messenger-align-middle"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
