<script src="../Style/toastr/toastr.js"></script>
<div id="pjax-container">
    <div class="lg-sidebar">
      <ul>
        <li class="lg-sidebar-item" title="返回顶部" onclick="scrollToTop()">
            <svg t="1756821690254"class="lg-sidebar-icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="59481" width="256" height="256"><path d="M898.346667 932.693333c-9.088 9.088-18.176 9.088-31.744 4.565334L512.853333 738.133333l-354.346666 200.234667c-13.653333 4.522667-22.741333 4.522667-31.786667-4.522667-9.045333-9.045333-9.045333-18.133333-9.045333-27.221333l373.418666-835.626667c0.042667-9.045333 13.653333-13.653333 22.741334-13.653333 9.088 0 18.133333 9.045333 22.656 13.568l366.421333 839.125333c4.48 4.522667-0.042667 18.133333-4.608 22.698667z" fill="#ffffff" p-id="59482"></path>
            </svg>
        </li>
        <li class="lg-sidebar-item" title="小站首页" onclick="pjaxGoHome()">
            <a href="index.php" style="display:none;"></a>
            <svg t="1756821215261" class="lg-sidebar-icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5725" width="256" height="256"><path d="M920.38 408.41L584.24 65.21c-0.3-0.3-0.6-0.59-0.92-0.88-19.1-17.18-44.43-26.65-71.33-26.65-26.89 0-52.23 9.46-71.33 26.65-0.32 0.28-0.62 0.58-0.92 0.88l-336.12 343.2c-3.52 3.6-5.48 8.31-5.48 13.19v474.47c0.01 50.74 45.48 92.02 101.35 92.02H347.6c11.43 0 20.69-8.72 20.69-19.47V699.74c0-29.27 26.9-53.09 59.95-53.09h167.5c33.06 0 59.95 23.81 59.95 53.09v268.89c0 10.75 9.26 19.47 20.69 19.47h148.11c55.88 0 101.34-41.28 101.34-92.03V421.61c0.02-4.89-1.93-9.6-5.45-13.2z" fill="#ffffff" p-id="5726"></path>
            </svg>
        </li>
      </ul>
    </div>
    
    <script>
        function scrollToTop(duration = 500) {
          $('html, body').animate({ scrollTop: 0 }, duration);
        }
        
        
        window.pjaxGoHome = function() {
            $('.lg-sidebar-item a').first().each(function() {
                this.click();
            });
        };
        
        $(function () {
            
            initLoveAlbum();
            
            initScrollButton('#MessageBtn', '#MessageArea', 800, 800);

                        
            let $tooltip;
            
            function showTooltip($element) {
                const tipText = $element.data('tip') || '';
                const position = $element.data('tip-position') || 'top';
            
                if (!$tooltip) {
                    $tooltip = $('<div class="custom-tooltip"></div>').appendTo('body');
                }
                $tooltip.text(tipText).removeClass('top bottom left right').addClass(position).show();
            
                // 获取元素相对于页面的绝对位置
                const offset = $element.offset();
                const elWidth = $element.outerWidth();
                const elHeight = $element.outerHeight();
            
                $tooltip.css({ visibility: 'hidden', display: 'block' }); // 临时显示计算大小
                const tipWidth = $tooltip.outerWidth();
                const tipHeight = $tooltip.outerHeight();
            
                let top = 0, left = 0;
                switch (position) {
                    case 'top':
                        top = offset.top - tipHeight - 10;
                        left = offset.left + (elWidth - tipWidth) / 2;
                        break;
                    case 'bottom':
                        top = offset.top + elHeight + 10;
                        left = offset.left + (elWidth - tipWidth) / 2;
                        break;
                    case 'left':
                        top = offset.top + (elHeight - tipHeight) / 2;
                        left = offset.left - tipWidth - 10;
                        break;
                    case 'right':
                        top = offset.top + (elHeight - tipHeight) / 2;
                        left = offset.left + elWidth + 10;
                        break;
                }
            
                // 边界处理
                const viewportWidth = $(window).width();
                const viewportHeight = $(window).height();
                if (left < 10) left = 10;
                if (left + tipWidth > viewportWidth - 10) left = viewportWidth - tipWidth - 10;
                if (top < 10) top = 10;
                if (top + tipHeight > $(document).height() - 10) top = $(document).height() - tipHeight - 10;
            
                $tooltip.css({ top: top + 'px', left: left + 'px', visibility: 'visible', opacity : 1 });
            }
            
            function hideTooltip() {
                if ($tooltip) $tooltip.hide();
            }
            
            // 事件绑定
            $(document).on({
                mouseenter: function() { showTooltip($(this)); },
                mouseleave: function() { hideTooltip(); }
            }, '[data-tip]');
            
            // 滚动或 touch 时隐藏
            $(window).on('scroll touchstart touchmove', hideTooltip);
            
            $('.card, .card-b').click(function() {
                var link = $(this).find('a').get(0);
                if (link) {
                    link.click();
                }
            });
        

            $('video').each(function() {
                var video = $(this);
                setupVideoPlayer(video);
            });

            
            $(".love_img img,.lovelist img,.little_texts img").addClass("spotlight").each(function () {
                this.onclick = function () {
                    return hs.expand(this)
                }
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "rtl": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": 300,
                    "hideDuration": 1000,
                    "timeOut": 5000,
                    "extendedTimeOut": 1000,
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
            });

            window.onscroll = function () {
                let scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
                if (scrollTop > 500) {
                    $('.wenan').css({
                        'color': '#333333'
                    });
                    $('.alogo').css({
                        'color': '#333333'
                    });
                }

                if (scrollTop < 500) {
                    $('.wenan').css({
                        'color': 'rgb(97 97 97)'
                    });
                    $('.alogo').css({
                        'color': 'rgb(97 97 97)'
                    });
                }
            }

            FunLazy({
                placeholder: "Style/img/Loading2.gif",
                effect: "show",
                strictLazyMode: false,
                useErrorImagePlaceholder: "Style/img/error.svg"
            })
            


        })


    </script>
    <style>
        .icon {
            width: 1.5em;
            height: 1.5em;
            vertical-align: -0.3em;
            fill: currentColor;
            overflow: hidden;
        }

        li.cike {
            border-bottom: 1px solid #ddd;
        }

        li {
            list-style-type: none;
        }

        .cike:hover {
            cursor: pointer;
            cursor: url(../Style/cur/hover.cur), pointer;
        }

        button:disabled {
            background: #888;
            opacity: 0.6;
        }

        .avatar {
            width: 3em;
            height: 3em;
            border-radius: 50%;
            box-shadow: 0 2px 20px #c5c5c575;
            border: 2px solid #fff;
            margin-right: 0.8rem;
        }
    </style>
</div>

<?php if ($icp <> '' || $copy <> ''): ?>
    <div class="footer-warp">
        <div class="footer">
            <?php if ($icp): ?>
                <p><img src="../Style/img/icp.svg"><a href="https://beian.miit.gov.cn/#/Integrated/index" target="_blank"><?php echo $icp ?></a></p>
            <?php endif;
            if ($copy): ?>
                <p><?php echo $copy ?></p>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>


<?php echo htmlspecialchars_decode($diy['footerCon'], ENT_QUOTES) ?>