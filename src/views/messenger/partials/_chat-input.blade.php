<div class="messenger-position-relative">
    <div class="messenger-chat-input-section messenger-p-4 messenger-border-top">

        @include('messenger::partials._chat-form')

    </div>

    <div class="messenger-replyCard">
        <div class="messenger-card messenger-mb-0">
            <div class="messenger-card-body messenger-py-3">
                <div class="messenger-replymessage-block messenger-mb-0 messenger-d-flex messenger-align-items-start">
                    <div class="messenger-flex-grow-1">
                        <h5 class="messenger-conversation-name"></h5>
                        <p class="messenger-mb-0"></p>
                    </div>
                    <div class="messenger-flex-shrink-0">
                        <button type="button" id="close_toggle" class="messenger-btn messenger-btn-sm messenger-btn-link messenger-mt-n2 messenger-me-n3 messenger-fs-18">
                            <i class="bx bx-x messenger-align-middle"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
