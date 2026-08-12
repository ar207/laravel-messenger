@if(!empty($messages))
    @foreach($messages as $key => $message)
        @php
            $messageAlignClass = 'messenger-left';
            $messageTextClass = 'messenger-text-black';
            if (!empty($message['is_send'])) {
                $messageAlignClass = 'messenger-right';
                $messageTextClass = 'messenger-text-white';
            }
        @endphp

        <li class="messenger-chat-list {{ $messageAlignClass }}" id="message_{{ $message['id'] }}">
            <div class="messenger-conversation-list">
                @if(empty($message['is_send']))
                    <div class="messenger-chat-avatar" style="height: 2.3rem; width: 2.3rem;">
                        <span
                            class="messenger-avatar-title messenger-rounded-circle messenger-bg-primary messenger-text-white">
                            <span class="messenger-username">{{ $user_avatar_name }}</span>
                        </span>
                    </div>
                @endif
                <div class="messenger-user-chat-content">
                    <div class="messenger-ctext-wrap">
                        @php
                            $imageExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.bmp', '.webp', '.tiff', '.svg', '.ico'];
                            $videoExtensions = ['.mp4', '.mov', '.avi', '.wmv', '.mkv', '.flv', '.webm', '.mpeg', '.3gp', '.mpg'];
                        @endphp
                        @if(!empty($message['message_file']))
                            @if(in_array(strtolower($message['file_type']), $imageExtensions))
                                <div class="messenger-img mb-0">
                                    <div class="messenger-img-list">
                                        <div>
                                            <a class="messenger-popup-img messenger-d-inline-block" href="#!">
                                                <img src="{{ $message['message_file'] }}" alt="" class="messenger-rounded messenger-border messenger-img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="messenger-img-link">
                                            <ul class="messenger-list-inline messenger-mb-0">
                                                <li class="messenger-list-inline-item messenger-dropdown">
                                                    <a class="messenger-dropdown-toggle" href="#" role="button"
                                                       data-bs-toggle="messenger-dropdown" aria-haspopup="true"
                                                       aria-expanded="false">
                                                        <i class="bx bx-dots-horizontal-rounded"></i> </a>
                                                    <div class="messenger-dropdown-menu">
                                                        <a class="messenger-dropdown-item messenger-d-flex messenger-align-items-center messenger-justify-content-between"
                                                           href="{{ $message['message_file'] }}" download>
                                                            Download
                                                            <i class="bx bx-download messenger-ms-2 messenger-text-muted"></i>
                                                        </a>
                                                        <a class="messenger-dropdown-item messenger-d-flex messenger-align-items-center messenger-justify-content-between delete-message"
                                                           id="delete_{{ $message['id'] }}" href="#">
                                                            Delete
                                                            <i class="bx bx-trash messenger-ms-2 messenger-text-muted"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @elseif(in_array(strtolower($message['file_type']), $videoExtensions))
                                <div class="messenger-img mb-0">
                                    <div class="messenger-img-list">
                                        <div>
                                            <video controls class="messenger-rounded messenger-border messenger-video-thumbnail" style="width: 300px !important;">
                                                <source src="{{ $message['message_file'] }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                        <div class="messenger-img-link">
                                            <ul class="messenger-list-inline messenger-mb-0">
                                                <li class="messenger-list-inline-item messenger-dropdown">
                                                    <a class="messenger-dropdown-toggle" href="#" role="button"
                                                       data-bs-toggle="messenger-dropdown" aria-haspopup="true"
                                                       aria-expanded="false">
                                                        <i class="bx bx-dots-horizontal-rounded"></i> </a>
                                                    <div class="messenger-dropdown-menu">
                                                        <a class="messenger-dropdown-item messenger-d-flex messenger-align-items-center messenger-justify-content-between"
                                                           href="{{ $message['message_file'] }}" download>
                                                            Download
                                                            <i class="bx bx-download messenger-ms-2 messenger-text-muted"></i>
                                                        </a>
                                                        <a class="messenger-dropdown-item messenger-d-flex messenger-align-items-center messenger-justify-content-between delete-message"
                                                           id="delete_{{ $message['id'] }}" href="#">
                                                            Delete
                                                            <i class="bx bx-trash messenger-ms-2 messenger-text-muted"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @php
                                    $bgSoftLight = 'messenger-bg-soft-dark';
                                    $border = 'messenger-border-dark';
                                    $messageTextClass = 'messenger-text-black';
                                    if (!empty($message['is_send'])) {
                                        $bgSoftLight = 'messenger-bg-soft-light';
                                        $border = 'messenger-border';
                                        $messageTextClass = 'messenger-text-white';
                                    }
                                @endphp
                                <div class="messenger-ctext-wrap-content">
                                    <div class="messenger-p-3 {{ $border }} messenger-rounded-3">
                                        <div class="messenger-d-flex messenger-align-items-center messenger-attached-file">
                                            <div class="messenger-flex-shrink-0 messenger-avatar-sm messenger-me-3 messenger-ms-0 messenger-attached-file-avatar">
                                                <div class="messenger-avatar-title {{ $bgSoftLight }} messenger-rounded-circle messenger-fs-20">
                                                    <i class="{{ \mar\messenger\Helpers\Messenger::getFileIcon($message['file_type']) }}"></i>
                                                </div>
                                            </div>
                                            <div class="messenger-flex-grow-1 messenger-overflow-hidden">
                                                <div class="messenger-text-start">
                                                    <h5 class="messenger-fs-14 {{ $messageTextClass }} messenger-mb-1">
                                                        {{ $message['file_original_name'] }}
                                                    </h5>
                                                    <p class="{{ $messageTextClass }} messenger-text-truncate messenger-fs-13 messenger-mb-0">
                                                        {{ $message['file_size'] }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="messenger-flex-shrink-0 messenger-ms-4">
                                                <div class="messenger-d-flex messenger-gap-2 messenger-fs-20 messenger-d-flex messenger-align-items-start">
                                                    <div>
                                                        <a href="{{ $message['message_file'] }}" download="" class="{{ $messageTextClass }}">
                                                            <i class="bx bxs-download"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="messenger-img-link">
                                    <ul class="messenger-list-inline messenger-mb-0">
                                        <li class="messenger-list-inline-item messenger-dropdown">
                                            <a class="messenger-dropdown-toggle" href="#" role="button"
                                               data-bs-toggle="messenger-dropdown" aria-haspopup="true"
                                               aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i> </a>
                                            <div class="messenger-dropdown-menu">
                                                <a class="messenger-dropdown-item messenger-d-flex messenger-align-items-center messenger-justify-content-between"
                                                   href="{{ $message['message_file'] }}" download>
                                                    Download
                                                    <i class="bx bx-download messenger-ms-2 messenger-text-muted"></i>
                                                </a>
                                                <a class="messenger-dropdown-item messenger-d-flex messenger-align-items-center messenger-justify-content-between delete-message"
                                                   id="delete_{{ $message['id'] }}" href="#">
                                                    Delete
                                                    <i class="bx bx-trash messenger-ms-2 messenger-text-muted"></i>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        @else
                            <div class="messenger-ctext-wrap-content">
                                <p class="messenger-mb-0 messenger-ctext-content">{{ $message['message'] }}</p>
                            </div>
                            <div class="messenger-align-self-start messenger-message-box-drop messenger-d-flex">
                                <div class="messenger-dropdown">
                                    <a class="messenger-dropdown-toggle" href="#" role="button"
                                       data-bs-toggle="messenger-dropdown" aria-haspopup="true"
                                       aria-expanded="false">
                                        <i class="ri-more-2-fill"></i>
                                    </a>
                                    <div class="messenger-dropdown-menu">
                                        <a class="messenger-dropdown-item messenger-d-flex messenger-align-items-center messenger-justify-content-between delete-message"
                                           id="delete_{{ $message['id'] }}" href="javascript:void(0)">Delete
                                            <i class="bx bx-trash messenger-text-muted messenger-ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="messenger-conversation-name">
                        <small class="messenger-text-muted messenger-time">{{ $message['message_time'] }}</small>
                        <span class="messenger-text-success messenger-check-message-icon">
                            <i class="bx bx-check-double"></i>
                        </span>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
@endif
