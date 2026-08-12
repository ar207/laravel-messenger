var input, filter, ul, li, a, i, j, div;

!function () {
    var v = !1, g = "users-chat", o = "assets/images/users/user-dummy-img.jpg", d = "users", s = "assets/js/dir/",
        u = "", m = 1;

    var t = document.querySelector(".user-profile-sidebar");
    document.querySelectorAll(".user-profile-show").forEach(function (e) {
        e.addEventListener("click", function (e) {
            t.classList.toggle("d-block")
        })
    });
    window.addEventListener("DOMContentLoaded", function () {
        var e = document.querySelector("#chat-conversation .messenger-simplebar-content-wrapper");
        e.scrollTop = e.scrollHeight
    });

    var i = document.getElementById("chatinputmorecollapse");

    function h(e) {
        var t = document.getElementById(e).querySelector("#chat-conversation .messenger-simplebar-content-wrapper"),
            a = document.getElementsByClassName("messenger-chat-conversation-list")[0] ? document.getElementById(e).getElementsByClassName("messenger-chat-conversation-list")[0].scrollHeight - window.innerHeight + 250 : 0;
        a && t.scrollTo({top: a, behavior: "smooth"})
    }

    document.body.addEventListener("click", function () {
        new bootstrap.Collapse(i, {toggle: !1}).hide()
    }), i && i.addEventListener("shown.bs.collapse", function () {
        new Swiper(".chatinput-links", {
            slidesPerView: 3,
            spaceBetween: 30,
            breakpoints: {768: {slidesPerView: 4}, 1024: {slidesPerView: 6}}
        })
    }), document.querySelectorAll(".contact-modal-list .contact-list li").forEach(function (e) {
        e.addEventListener("click", function () {
            e.classList.toggle("selected")
        })
    })

    function a() {
        var a = document.getElementsByClassName("messenger-user-chat");
        document.querySelectorAll(".messenger-chat-user-list li a").forEach(function(e) {
            e.addEventListener("click", function(e) {
                a.forEach(function(e) {
                    e.classList.add("messenger-user-chat-show")
                });
                var t = document.querySelector(".messenger-chat-user-list li.active");
                t && t.classList.remove("active"),
                    this.parentNode.classList.add("active")
            })
        }),
            document.querySelectorAll(".sort-contact ul li").forEach(function(e) {
                e.addEventListener("click", function(e) {
                    a.forEach(function(e) {
                        e.classList.add("messenger-user-chat-show")
                    })
                })
            }),
            document.querySelectorAll(".messenger-user-chat-remove").forEach(function(e) {
                e.addEventListener("click", function(e) {
                    a.forEach(function(e) {
                        e.classList.remove("messenger-user-chat-show")
                    })
                })
            })
    }

    var l = document.querySelector("#chatinput-form"), y = document.querySelector("#chat-input"),
        b = document.querySelector(".messenger-chat-conversation-list");
    document.querySelector(".messenger-chat-input-feedback");

    var w, n, S = 0, E = [], c = 1, k = "";

    var q, L, p, j = [], A = 1;
    var C = [];

    l && l.addEventListener("submit", function (e) {
        e.preventDefault();
        var t, a, s, i, l = g, o = g, r = g, n = g, c = g, d = y.value, u = document.querySelector(".image_pre"),
            m = document.querySelector(".attchedfile_pre"), p = document.querySelector(".audiofile_pre"),
            f = document.querySelector(".chat-input-feedback");
        0 === d.length ? (f.classList.add("show"), setTimeout(function () {
            f.classList.remove("show")
        }, 2e3), null != u ? (f.classList.remove("show"), t = o, a = C, s = document.getElementById(t).querySelector(".messenger-chat-conversation-list"), i = "", a.forEach(function (e) {
            i += '<div class="message-img-list">          <div>            <a class="popup-img d-inline-block" href="' + e + '" target="_blank">                <img src="' + e + '" alt="" class="rounded border img-thumbnail" width="200" />            </a>          </div>          <div class="message-img-link">            <ul class="list-inline mb-0">              <li class="list-inline-item dropdown">                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                    <i class="bx bx-dots-horizontal-rounded"></i>                </a>          <div class="dropdown-menu">            <a class="dropdown-item d-flex align-items-center justify-content-between" href="' + e + '" download>Download <i class="bx bx-download ms-2 text-muted"></i></a>            <a class="dropdown-item d-flex align-items-center justify-content-between" href="#" data-bs-toggle="collapse" data-bs-target=".replyCollapse">Reply <i class="bx bx-share ms-2 text-muted"></i></a>            <a class="dropdown-item d-flex align-items-center justify-content-between" href="#" data-bs-toggle="modal" data-bs-target=".forwardModal">Forward <i class="bx bx-share-alt ms-2 text-muted"></i></a>            <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Bookmark <i class="bx bx-bookmarks text-muted ms-2"></i></a>            <a class="dropdown-item d-flex align-items-center justify-content-between delete-image" id="delete-item-' + ++S + '" href="#">Delete <i class="bx bx-trash text-muted ms-2"></i></a>          </div>        </li>      </ul>    </div>    </div>'
        }), null != a && (s.insertAdjacentHTML("beforeend", '<li class="chat-list right" id="chat-list-' + S + '" >        <div class="conversation-list">            <div class="user-chat-content">                <div class="ctext-wrap">                        <div class="message-img mb-0">' + i + '                    </div>                    </div>                  <div class="conversation-name">                    <small class="text-muted time">' + x() + '</small>                    <span class="text-success check-message-icon"><i class="bx bx-check"></i></span>                </div>          </div>        </li>'), _(), b.querySelectorAll(".chat-list").forEach(function (e) {
            e.querySelectorAll(".delete-image").forEach(function (e) {
                e.addEventListener("click", function () {
                    1 == e.closest(".message-img").childElementCount ? e.closest(".chat-list").remove() : e.closest(".message-img-list").remove()
                })
            })
        }), B.querySelectorAll(".chat-list").forEach(function (e) {
            e.querySelectorAll(".delete-image").forEach(function (e) {
                e.addEventListener("click", function () {
                    1 == e.closest(".message-img").childElementCount ? e.closest(".chat-list").remove() : e.closest(".message-img-list").remove()
                })
            })
        })), document.querySelector(".messenger-file_Upload").classList.remove("show"), C = []) : null != m ? (f.classList.remove("show"), function (e, t, a) {
            t = q, a = L;
            S++;
            var s = document.getElementById(e).querySelector(".messenger-chat-conversation-list");
            null != t && s.insertAdjacentHTML("beforeend", '<li class="chat-list right" id="chat-list-' + S + '" >          <div class="conversation-list">              <div class="user-chat-content">                  <div class="ctext-wrap">                      <div class="ctext-wrap-content">                          <div class="p-3 border rounded-3">                              <div class="d-flex align-items-center attached-file">                                  <div class="flex-shrink-0 avatar-sm me-3 ms-0 attached-file-avatar">                                      <div class="avatar-title bg-soft-light rounded-circle fs-20"><i class="ri-attachment-2"></i></div>                                  </div>                                  <div class="flex-grow-1 overflow-hidden">                                      <div class="text-start">                                          <h5 class="fs-14 text-white mb-1">' + t + '</h5>                                          <p class="text-white-50 text-truncate fs-13 mb-0">' + a + 'mb</p>                                      </div>                                  </div>                                  <div class="flex-shrink-0 ms-4">                                      <div class="d-flex gap-2 fs-20 d-flex align-items-start">                                          <div>                                              <a href="#" class="text-white-50 download-file" data-id="' + A + '"> <i class="bx bxs-download"></i> </a>                                          </div>                                      </div>                                  </div>                              </div>                          </div>                      </div>                      <div class="align-self-start message-box-drop d-flex">                      <div class="dropdown">                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                          <i class="ri-emotion-happy-line"></i>                        </a>                        <div class="dropdown-menu emoji-dropdown-menu">                          <div class="hstack align-items-center gap-2 px-2 fs-25">                            <a href="javascript:void(0);">💛</a>                            <a href="javascript:void(0);">🤣</a>                            <a href="javascript:void(0);">😜</a>                            <a href="javascript:void(0);">😘</a>                            <a href="javascript:void(0);">😍</a>                            <div class="avatar-xs">                            <a href="javascript:void(0);" class="avatar-title bg-soft-primary rounded-circle fs-19 text-primary">+</a>                            </div>                          </div>                        </div>                      </div>                      <div class="dropdown">                          <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ri-more-2-fill"></i> </a>                          <div class="dropdown-menu">            <a class="dropdown-item d-flex align-items-center justify-content-between" href="' + t + '" download>Download <i class="bx bx-download ms-2 text-muted"></i></a>            <a class="dropdown-item d-flex align-items-center justify-content-between" href="#" data-bs-toggle="collapse" data-bs-target=".replyCollapse">Reply <i class="bx bx-share ms-2 text-muted"></i></a>            <a class="dropdown-item d-flex align-items-center justify-content-between" href="#" data-bs-toggle="modal" data-bs-target=".forwardModal">Forward <i class="bx bx-share-alt ms-2 text-muted"></i></a>            <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Bookmark <i class="bx bx-bookmarks text-muted ms-2"></i></a>                          <a class="dropdown-item d-flex align-items-center justify-content-between delete-item" id="delete-item-' + S + '" href="#">Delete <i class="bx bx-trash text-muted ms-2"></i></a>                      </div>                    </div>                    </div>                  </div>                <div class="conversation-name">                    <small class="text-muted time">' + x() + '</small>                      <span class="text-success check-message-icon"><i class="bx bx-check"></i></span>                    </div>                </div>              </div>            </li>');
            var i = document.getElementById("chat-list-" + S);
            i.querySelectorAll(".delete-item").forEach(function (e) {
                e.addEventListener("click", function () {
                    b.removeChild(i)
                })
            }), i.querySelectorAll(".download-file").forEach(function (i) {
                i.addEventListener("click", function (e) {
                    e.preventDefault();
                    var t, a, s = i.getAttribute("data-id");
                    window.File && window.FileReader && window.FileList && window.Blob ? (t = new Blob([j[s]], {type: "application/pdf"}), (a = document.createElement("a")).href = window.URL.createObjectURL(t), a.download = j[s].name, a.click()) : alert("The File APIs are not fully supported in this browser.")
                })
            }), document.querySelector(".messenger-file_Upload ").classList.remove("show")
        }(r, d)) : null != p && (f.classList.remove("show"), function (e, t) {
            t = w;
            S++;
            var a = document.getElementById(e).querySelector(".messenger-chat-conversation-list");
            null != t && a.insertAdjacentHTML("beforeend", '<li class="chat-list right" id="chat-list-' + S + '" >          <div class="conversation-list">              <div class="user-chat-content">                  <div class="ctext-wrap">                  <div class="audio-file-elem">                              <audio controls>                                  <source src="' + k + '" type="audio/mpeg">                              </audio>                          </div>                      <div class="align-self-start message-box-drop d-flex">                      <div class="dropdown">                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                          <i class="ri-emotion-happy-line"></i>                        </a>                        <div class="dropdown-menu emoji-dropdown-menu">                          <div class="hstack align-items-center gap-2 px-2 fs-25">                            <a href="javascript:void(0);">💛</a>                            <a href="javascript:void(0);">🤣</a>                            <a href="javascript:void(0);">😜</a>                            <a href="javascript:void(0);">😘</a>                            <a href="javascript:void(0);">😍</a>                            <div class="avatar-xs">                            <a href="javascript:void(0);" class="avatar-title bg-soft-primary rounded-circle fs-19 text-primary">+</a>                            </div>                          </div>                        </div>                      </div>                        <div class="dropdown">                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ri-more-2-fill"></i> </a>                            <div class="dropdown-menu">            <a class="dropdown-item d-flex align-items-center justify-content-between" href="' + t + '" download>Download <i class="bx bx-download ms-2 text-muted"></i></a>            <a class="dropdown-item d-flex align-items-center justify-content-between" href="#" data-bs-toggle="collapse" data-bs-target=".replyCollapse">Reply <i class="bx bx-share ms-2 text-muted"></i></a>            <a class="dropdown-item d-flex align-items-center justify-content-between" href="#" data-bs-toggle="modal" data-bs-target=".forwardModal">Forward <i class="bx bx-share-alt ms-2 text-muted"></i></a>            <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Bookmark <i class="bx bx-bookmarks text-muted ms-2"></i></a>                                <a class="dropdown-item d-flex align-items-center justify-content-between delete-item" id="delete-item-' + S + '" href="#">Delete <i class="bx bx-trash text-muted ms-2"></i></a>                            </div>                        </div>                      </div>                      </div>                      <div class="conversation-name">                          <small class="text-muted time">' + x() + '</small>                            <span class="text-success check-message-icon"><i class="bx bx-check"></i></span>                          </div>                        </div>                      </div>                    </li>');
            var s = document.getElementById("chat-list-" + S);
        }(n, d))) : 1 == v ? (function (e, t) {
            var a = document.querySelector(".user-profile-show").innerHTML,
                s = document.querySelector(".messenger-replyCard .messenger-replymessage-block .flex-grow-1 .mb-0").innerText;
            S++;
            var i = document.getElementById(e).querySelector(".messenger-chat-conversation-list");
            null != t && (i.insertAdjacentHTML("beforeend", '<li class="chat-list right" id="chat-list-' + S + '" >                <div class="conversation-list">                    <div class="user-chat-content">                        <div class="ctext-wrap">                            <div class="ctext-wrap-content">                            <div class="replymessage-block mb-0 d-flex align-items-start">                        <div class="flex-grow-1">                            <h5 class="conversation-name">' + a + '</h5>                            <p class="mb-0">' + s + '</p>                        </div>                        <div class="flex-shrink-0">                            <button type="button" class="btn btn-sm btn-link mt-n2 me-n3 fs-18">                            </button>                        </div>                    </div>                                <p class="mb-0 ctext-content mt-1">                                    ' + t + '                                </p>                            </div>                            <div class="align-self-start message-box-drop d-flex">                            <div class="dropdown">                              <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                                <i class="ri-emotion-happy-line"></i>                              </a>                              <div class="dropdown-menu emoji-dropdown-menu">                                <div class="hstack align-items-center gap-2 px-2 fs-25">                                  <a href="javascript:void(0);">💛</a>                                  <a href="javascript:void(0);">🤣</a>                                  <a href="javascript:void(0);">😜</a>                                  <a href="javascript:void(0);">😘</a>                                  <a href="javascript:void(0);">😍</a>                                  <div class="avatar-xs">                                    <a href="javascript:void(0);" class="avatar-title bg-soft-primary rounded-circle fs-19 text-primary">+</a>                                  </div>                                </div>                              </div>                            </div>                              <div class="dropdown">                                  <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                                      <i class="ri-more-2-fill"></i>                                  </a>                                  <div class="dropdown-menu">                                      <a class="dropdown-item d-flex align-items-center justify-content-between reply-message" href="#" data-bs-toggle="collapse" data-bs-target=".replyCollapse">Reply <i class="bx bx-share ms-2 text-muted"></i></a>                                      <a class="dropdown-item d-flex align-items-center justify-content-between" href="#" data-bs-toggle="modal" data-bs-target=".forwardModal">Forward <i class="bx bx-share-alt ms-2 text-muted"></i></a>                                      <a class="dropdown-item d-flex align-items-center justify-content-between copy-message" href="#" id="copy-message-' + S + '">Copy <i class="bx bx-copy text-muted ms-2"></i></a>                                      <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Bookmark <i class="bx bx-bookmarks text-muted ms-2"></i></a>                                      <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Mark as Unread <i class="bx bx-message-error text-muted ms-2"></i></a>                                      <a class="dropdown-item d-flex align-items-center justify-content-between delete-item" id="delete-item-' + S + '" href="#">Delete <i class="bx bx-trash text-muted ms-2"></i></a>                              </div>                            </div>                        </div>                    </div>                    <div class="conversation-name">                        <small class="text-muted time">' + x() + '</small>                        <span class="text-success check-message-icon"><i class="bx bx-check"></i></span>                    </div>                </div>            </div>        </li>'), 0);
            var l = document.getElementById("chat-list-" + S);
            l.querySelectorAll(".delete-item").forEach(function (e) {
                e.addEventListener("click", function () {
                    b.removeChild(l)
                })
            }), l.querySelectorAll(".messenger-reply-message").forEach(function (s) {
                s.addEventListener("click", function () {
                    var e = s.closest(".messenger-ctext-wrap").children[0].children[0].innerText,
                        t = document.querySelector(".messenger-user-profile-show").innerHTML;
                    document.querySelector(".messenger-replyCard .messenger-replymessage-block .messenger-flex-grow-1 .messenger-mb-0").innerText = e;
                    var a = !s.closest(".messenger-chat-list") || s.closest(".messenger-chat-list").classList.contains("left") ? t : "You";
                    document.querySelector(".messenger-replyCard .messenger-replymessage-block .messenger-flex-grow-1 .messenger-conversation-name").innerText = a
                })
            }), l.querySelectorAll(".messenger-copy-message").forEach(function (e) {
                e.addEventListener("click", function () {
                    l.childNodes[1].children[1].firstElementChild.firstElementChild.getAttribute("id"), isText = l.childNodes[1].children[1].firstElementChild.firstElementChild.innerText, navigator.clipboard.writeText(isText)
                })
            })
        }(c, d), v = !1) : function (e, t) {
            S++;
            var a = document.getElementById(e).querySelector(".messenger-chat-conversation-list");
            null != t && a.insertAdjacentHTML("beforeend", '<li class="chat-list right" id="chat-list-' + S + '" >                <div class="conversation-list">                    <div class="user-chat-content">                        <div class="ctext-wrap">                            <div class="ctext-wrap-content">                                <p class="mb-0 ctext-content">' + t + '</p>                            </div>                            <div class="align-self-start message-box-drop d-flex">                            <div class="dropdown">                              <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                                <i class="ri-emotion-happy-line"></i>                              </a>                              <div class="dropdown-menu emoji-dropdown-menu">                                <div class="hstack align-items-center gap-2 px-2 fs-25">                                  <a href="javascript:void(0);">💛</a>                                  <a href="javascript:void(0);">🤣</a>                                  <a href="javascript:void(0);">😜</a>                                  <a href="javascript:void(0);">😘</a>                                  <a href="javascript:void(0);">😍</a>                                  <div class="avatar-xs">                                  <a href="javascript:void(0);" class="avatar-title bg-soft-primary rounded-circle fs-19 text-primary">+</a>                                  </div>                                </div>                              </div>                            </div>                              <div class="dropdown">                                  <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                                      <i class="ri-more-2-fill"></i>                                  </a>                                  <div class="dropdown-menu">                                      <a class="dropdown-item d-flex align-items-center justify-content-between reply-message" href="#" data-bs-toggle="collapse" data-bs-target=".replyCollapse">Reply <i class="bx bx-share ms-2 text-muted"></i></a>                                      <a class="dropdown-item d-flex align-items-center justify-content-between" href="#" data-bs-toggle="modal" data-bs-target=".forwardModal">Forward <i class="bx bx-share-alt ms-2 text-muted"></i></a>                                      <a class="dropdown-item d-flex align-items-center justify-content-between copy-message" href="#" id="copy-message-' + S + '">Copy <i class="bx bx-copy text-muted ms-2"></i></a>                                      <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Bookmark <i class="bx bx-bookmarks text-muted ms-2"></i></a>                                      <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Mark as Unread <i class="bx bx-message-error text-muted ms-2"></i></a>                                      <a class="dropdown-item d-flex align-items-center justify-content-between delete-item" id="delete-item-' + S + '" href="#">Delete <i class="bx bx-trash text-muted ms-2"></i></a>                              </div>                            </div>                        </div>                    </div>                    <div class="conversation-name">                        <small class="text-muted time">' + x() + '</small>                        <span class="text-success check-message-icon"><i class="bx bx-check"></i></span>                    </div>                </div>            </div>        </li>');
            var s = document.getElementById("chat-list-" + S);
            s.querySelectorAll(".delete-item").forEach(function (e) {
                e.addEventListener("click", function () {
                    a.removeChild(s)
                })
            }), s.querySelectorAll(".reply-message").forEach(function (i) {
                i.addEventListener("click", function () {
                    var e = document.querySelector(".replyCard"), t = document.querySelector("#close_toggle"),
                        a = i.closest(".ctext-wrap").children[0].children[0].innerText,
                        s = document.querySelector(".user-profile-show").innerHTML;
                    v = !0, e.classList.add("show"), t.addEventListener("click", function () {
                        e.classList.remove("show")
                    }), document.querySelector(".replyCard .replymessage-block .flex-grow-1 .mb-0").innerText = a, document.querySelector(".replyCard .replymessage-block .flex-grow-1 .conversation-name").innerText = s
                })
            }), s.querySelectorAll(".copy-message").forEach(function (e) {
                e.addEventListener("click", function () {
                    var e = s.childNodes[1].firstElementChild.firstElementChild.firstElementChild.firstElementChild.innerText;
                    navigator.clipboard.writeText(e)
                })
            })
        }(l, d), h(l || o || r || n || c), y.value = "", document.querySelector(".image_pre") && document.querySelector(".image_pre").remove(), document.getElementById("galleryfile-input").value = "", document.querySelector(".attchedfile_pre") && document.querySelector(".attchedfile_pre").remove(), document.getElementById("close_toggle").click()
    });
    var B = document.querySelector("#channel-conversation");
    for (var f = document.getElementsByClassName("favourite-btn"), M = 0; M < f.length; M++) {
        var T = f[M];
        T.onclick = function () {
            T.classList.toggle("active")
        }
    }
    new FgEmojiPicker({
        trigger: [".messenger-emoji-btn"],
        removeOnSelection: !1,
        closeButton: !0,
        position: ["top", "right"],
        preFetch: !0,
        dir: "laravel-messenger/js/dir/json",
        insertInto: document.querySelector(".messenger-chat-input")
    });

    function _() {
        GLightbox({selector: ".popup-img", title: !1})
    }

    document.getElementById("emoji-btn").addEventListener("click", function () {
        setTimeout(function () {
            var e, t = document.getElementsByClassName("fg-emoji-picker")[0];
            !t || (e = window.getComputedStyle(t) ? window.getComputedStyle(t).getPropertyValue("left") : "") && (e = (e = e.replace("px", "")) - 40 + "px", t.style.left = e)
        }, 0)
    })
}(), document.documentElement.style.setProperty("--bs-primary-rgb", window.localStorage.getItem("colorPrimary")), document.documentElement.style.setProperty("--bs-secondary-rgb", window.localStorage.getItem("colorSecondary"));
var primaryColor = window.getComputedStyle(document.body, null).getPropertyValue("--bs-primary-rgb");
