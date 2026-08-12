<div class="users-list messenger-d-none" data-simplebar="init">
    <div class="messenger-simplebar-wrapper" style="margin: 0px;">
        <div class="messenger-simplebar-height-auto-observer-wrapper">
            <div class="messenger-simplebar-height-auto-observer"></div>
        </div>
        <div class="messenger-simplebar-mask">
            <div class="messenger-simplebar-offset" style="right: 0px; bottom: 0px;">
                <div class="messenger-simplebar-content-wrapper" style="height: auto; overflow: hidden scroll;">
                    <div class="messenger-simplebar-content" style="padding: 0px;">
                        <h5 class="messenger-mb-3 messenger-px-4 messenger-mt-4 messenger-fs-11 messenger-text-muted messenger-text-uppercase">Chats</h5>

                        <div class="messenger-chat-message-list">
                            <ul class="messenger-list-unstyled messenger-chat-list">
                                @if(!empty($users))
                                    @foreach($users as $key => $user)
                                        <li id="contacts_{{ $user['id'] }}" data-type="{{ !empty($user['user_type']) ? $user['user_type'] : 'user' }}" data-id="{{ $user['id'] }}" class="contact_list">
                                            <a href="javascript: void(0);" class="messenger-unread-msg-user">
                                                <div class="messenger-d-flex messenger-align-items-center">
                                                    <div class="messenger-chat-user-img messenger-online messenger-align-self-center messenger-me-2 messenger-ms-0">
                                                        <div class="messenger-avatar-xs">
                                                            <span
                                                                class="messenger-avatar-title messenger-rounded-circle messenger-bg-primary messenger-text-white">
                                                                <span class="messenger-username">{{ \mar\messenger\Helpers\Messenger::nameLetters($user['name']) }}</span>
                                                                <span class="messenger-user-status"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="messenger-overflow-hidden me-2">
                                                        <p class="messenger-text-truncate messenger-chat-username messenger-mb-0">
                                                            {{ $user['name'] }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="messenger-simplebar-placeholder" style="width: auto; height: 1129px;"></div>
    </div>
</div>
