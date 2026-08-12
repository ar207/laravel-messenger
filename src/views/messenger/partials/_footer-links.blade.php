<script src="{{ asset('laravel-messenger/js/jquery.min.js') }}"></script>
<script src="{{ asset('laravel-messenger/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('laravel-messenger/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('laravel-messenger/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('laravel-messenger/libs/%40simonwep/pickr/pickr.min.js') }}"></script>
<script src="{{ asset('laravel-messenger/libs/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('laravel-messenger/libs/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('laravel-messenger/libs/fg-emoji-picker/fgEmojiPicker.js') }}"></script>
<script src="{{ asset('laravel-messenger/js/pages/index.init.js') }}"></script>
<script src="{{ asset('laravel-messenger/js/app.js') }}"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@php
    $currentUser = \mar\messenger\Helpers\Messenger::currentUser();
    $currentUserType = \mar\messenger\Helpers\Messenger::loginType();
    $messengerMode = !empty($currentUser) ? $currentUser->messenger_mode : '';
@endphp
<script>
    const messengerMode = "{{ !empty($messengerMode) ? "dark" : "light" }}";
    // Global messenger variable from PHP to JS
    window.messenger = {
        chatRoute: "{{ route('messenger.store') }}",
        selectUserRoute: "{{ route('messenger.user.select') }}",
        conversationRoute: "{{ route('messenger.user.conversation') }}",
        deleteMessageRoute: "{{ route('messenger.delete') }}",
        messengerModeRoute: "{{ route('messenger.mode.update') }}",
        makeSeen: "{{ route('messenger.message.seen') }}",
        token: "{{ csrf_token() }}",
        pusher: {!! json_encode(config('messenger.pusher')) !!},
        fileIcons: {!! json_encode(config('messenger.file_icons')) !!},
        currentUserId: "{{ !empty($currentUser) ? $currentUser->id : '' }}",
        currentUserType: "{{ !empty($currentUserType) ? $currentUserType : 'user' }}",
        receiverId: 0,
        receiverType: '',
        activeChatId: '',
    };

    $(document).ready(function () {
        updateMessengerMode(messengerMode);
        fetchMessages(messenger.currentUserId);
        searchContacts('#searchChatUser', '.users-list');
    });

</script>
<script src="{{ asset('laravel-messenger/js/messenger.js') }}"></script>
