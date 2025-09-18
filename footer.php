<script src="../Style/toastr/toastr.js"></script>
<div id="pjax-container">
    
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