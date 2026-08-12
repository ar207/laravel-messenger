<div class="messenger-chat-leftsidebar">

    <div class="messenger-tab-content">

        <div class="messenger-tab-pane show messenger-active" id="pills-chat" role="tabpanel"
             aria-labelledby="pills-chat-tab">
            <div>
                <div class="messenger-px-4 messenger-pt-4">
                    <div class="messenger-d-flex align-items-start">
                        <div class="messenger-flex-grow-1">
                            <h4 class="messenger-mb-4">Messages <span
                                        class="messenger-text-primary messenger-fs-13">(0)</span></h4>
                        </div>
                        <div class="messenger-dropdown messenger-flex-grow-0">
                            <button class="messenger-btn messenger-nav-btn messenger-dropdown-toggle" type="button"
                                    data-bs-toggle="messenger-dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="messenger-dropdown-menu messenger-dropdown-menu-end">
                                <a class="messenger-dropdown-item d-flex messenger-justify-content-between messenger-align-items-center light-dark-mode" href="#" data-id="0">
                                    <span class="mode-switcher">Dark Mode</span>  <i class="ri-moon-line mode-switcher-icon"></i>
                                </a>
                            </div>
                        </div>

                    </div>

                    @include('messenger::partials._search-users')
                </div>

                @include('messenger::partials._users-list')

                <div id="chat-threads">
                    @include('messenger::partials._chat-users')
                </div>
            </div>
        </div>
    </div>
</div>
