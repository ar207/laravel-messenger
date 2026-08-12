<div class="messenger-user-chat messenger-w-100 messenger-overflow-hidden messenger-d-none" id="conversation-main">
    <div class="messenger-chat-content messenger-d-lg-flex">
        <div class="messenger-w-100 messenger-overflow-hidden messenger-position-relative">
            <div id="users-chat" class="messenger-position-relative">
                <div class="messenger-py-3 messenger-user-chat-topbar">
                    <div class="messenger-row messenger-align-items-center">
                        @include('messenger::partials._conversation-header')

                        @include('messenger::partials._search-user-chat')
                    </div>
                </div>

                <div class="messenger-chat-conversation messenger-p-3 messenger-p-lg-4" id="chat-conversation" data-simplebar="init">
                    <div class="messenger-simplebar-wrapper">
                        <div class="messenger-simplebar-mask">
                            <div class="messenger-simplebar-offset" style="right: 0px; bottom: 0px;">
                                <div class="messenger-simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                                    <div class="messenger-simplebar-content" style="padding: 24px;">
                                        <ul class="messenger-list-unstyled messenger-chat-conversation-list" id="users-conversation"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="messenger-simplebar-placeholder" style="width: auto; height: 1179px;"></div>
                    </div>
                </div>
            </div>

            @include('messenger::partials._chat-input')
        </div>
    </div>
</div>
