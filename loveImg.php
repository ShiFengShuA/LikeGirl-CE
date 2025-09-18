<?php
include_once 'head.php';

$loveImg = "SELECT * FROM loveImg ORDER BY id DESC";
$resImg = mysqli_query($connect, $loveImg);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <link rel="stylesheet" href="Style/css/loveImg.css?LikeGirl=<?php echo $version ?>">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $text['title'] ?> — 恋爱相册</title>
</head>

<body>
    <div id="pjax-container">
        <h4 class="text-ce central fade-in">记录下你的最美瞬间</h4>
        <h4 style="text-align: center;" class="text-comment fade-in">为防止爬虫爬取图片 每个窗口首次访问时请刷新该页面</h4>
        <div class="album-container">
            <?php
            $index = 0;
            while ($list = mysqli_fetch_array($resImg)) {
                $date = isset($list['imgDatd']) ? $list['imgDatd'] : date('Y-m-d');
                $imgUrls = isset($list['imgUrl']) ? explode(';', $list['imgUrl']) : [];
                $imgCount = count($imgUrls);
                $displayCount = min($imgCount, 9);
                
                echo '<div class="photo-card photo-item" data-id="' . $list['id'] . '" data-description="' . htmlspecialchars($list['imgText']) . '" data-date="' . $date . '" data-images="' . htmlspecialchars($list['imgUrl']) . '" style="transition-delay: ' . ($index * 0.1) . 's;">';
                echo '<div class="photo-img-container">';
                
                if ($imgCount > 0) {
                    if ($imgCount === 1) {
                        echo '<img src="' . trim($imgUrls[0]) . '" alt="' . htmlspecialchars($list['imgText']) . '" class="single-img">';
                    } else {
                        echo '<div class="thumbnails-grid thumbnails-' . $displayCount . '">';
                        for ($i = 0; $i < $displayCount; $i++) {
                            echo '<div class="thumbnail-item">';
                            echo '<img src="' . trim($imgUrls[$i]) . '" alt="缩略图' . ($i + 1) . '" class="thumbnail-img">';
                            echo '</div>';
                        }
                        echo '</div>';
                        
                        if ($imgCount > 9) {
                            echo '<div class="multi-img-indicator">+' . ($imgCount - 9) . '</div>';
                        }
                    }
                } else {
                    echo '<img src="https://via.placeholder.com/300x220?text=No+Image" alt="暂无图片" class="single-img">';
                }
                
                echo '</div>';
                echo '<div class="photo-info">';
                echo '<div class="photo-description">' . htmlspecialchars($list['imgText']) . '</div>';
                echo '<div class="date">' . $date . '</div>';
                echo '</div></div>';
                
                $index++;
            }
            
            if ($index === 0) {
                echo '<div class="text-ce central" style="grid-column: 1 / -1;">暂无照片，快来上传第一张吧！</div>';
            }
            ?>
        </div>
        
        <!-- 模态框 -->
        <div class="modal" id="imageModal">
            <div class="close-modal" id="closeModal">&times;</div>
            <div class="nav-arrows">
                <div class="arrow" id="prevArrow">❮</div>
                <div class="arrow" id="nextArrow">❯</div>
            </div>
            <div class="modal-content">
                <img id="modalImage" class="modal-img" src="" alt="">
                <div class="modal-thumbnails" id="modalThumbnailsContainer"></div>
                <div class="modal-info">
                    <div class="modal-description" id="modalDescription"></div>
                    <div class="modal-date" id="modalDate"></div>
                </div>
            </div>
        </div>
    </div>
    
    <?php
    include_once 'footer.php';
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const modalDescription = document.getElementById('modalDescription');
            const modalDate = document.getElementById('modalDate');
            const closeModal = document.getElementById('closeModal');
            const prevArrow = document.getElementById('prevArrow');
            const nextArrow = document.getElementById('nextArrow');
            const modalThumbnailsContainer = document.getElementById('modalThumbnailsContainer');
            
            let currentImages = [];
            let currentIndex = 0;
            
            // 初始化动画效果
            function initAnimations() {
                const photoItems = document.querySelectorAll('.photo-item');
                photoItems.forEach(item => {
                    item.classList.add('show');
                });
            }
            
            // 延迟加载动画
            setTimeout(initAnimations, 100);
            
            // 绑定照片卡片点击事件
            function bindPhotoCardEvents() {
                document.querySelectorAll('.photo-card').forEach(card => {
                    card.addEventListener('click', function(e) {
                        // 检查是否点击的是缩略图
                        const thumbnail = e.target.closest('.thumbnail-item');
                        let clickedIndex = 0;
                        
                        if (thumbnail) {
                            clickedIndex = Array.from(thumbnail.parentNode.children).indexOf(thumbnail);
                        }
                        
                        const description = this.getAttribute('data-description');
                        const date = this.getAttribute('data-date');
                        const images = this.getAttribute('data-images').split(';').map(url => url.trim());
                        
                        currentImages = images.filter(url => url !== '');
                        currentIndex = Math.min(clickedIndex, currentImages.length - 1);
                        
                        if (currentImages.length > 0) {
                            // 显示加载中的模态框
                            modal.style.display = 'flex';
                            setTimeout(() => {
                                modal.classList.add('show');
                            }, 10);
                            
                            modalImage.classList.remove('loaded');
                            
                            // 预加载图片
                            const loadImage = new Image();
                            loadImage.src = currentImages[currentIndex];
                            loadImage.onload = function() {
                                modalImage.src = currentImages[currentIndex];
                                modalImage.classList.add('loaded');
                            };
                            
                            modalDescription.textContent = description;
                            modalDate.textContent = date;
                            
                            // 创建缩略图
                            modalThumbnailsContainer.innerHTML = '';
                            currentImages.forEach((url, index) => {
                                const thumbnail = document.createElement('img');
                                thumbnail.src = url;
                                thumbnail.className = 'modal-thumbnail' + (index === currentIndex ? ' active' : '');
                                thumbnail.addEventListener('click', (e) => {
                                    e.stopPropagation();
                                    currentIndex = index;
                                    updateModal();
                                });
                                modalThumbnailsContainer.appendChild(thumbnail);
                            });
                            
                            document.body.style.overflow = 'hidden';
                        }
                    });
                });
            }
            
            // 初始绑定事件
            bindPhotoCardEvents();
            
            // 关闭模态框
            closeModal.addEventListener('click', function() {
                modal.classList.remove('show');
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 300);
                document.body.style.overflow = 'auto';
            });
            
            // 点击模态框背景关闭
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.remove('show');
                    setTimeout(() => {
                        modal.style.display = 'none';
                    }, 300);
                    document.body.style.overflow = 'auto';
                }
            });
            
            // 上一张/下一张导航
            prevArrow.addEventListener('click', function(e) {
                e.stopPropagation();
                if (currentImages.length > 1) {
                    currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
                    updateModal();
                }
            });
            
            nextArrow.addEventListener('click', function(e) {
                e.stopPropagation();
                if (currentImages.length > 1) {
                    currentIndex = (currentIndex + 1) % currentImages.length;
                    updateModal();
                }
            });
            
            // 键盘导航
            document.addEventListener('keydown', function(e) {
                if (modal.classList.contains('show')) {
                    if (e.key === 'ArrowLeft') {
                        currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
                        updateModal();
                    } else if (e.key === 'ArrowRight') {
                        currentIndex = (currentIndex + 1) % currentImages.length;
                        updateModal();
                    } else if (e.key === 'Escape') {
                        modal.classList.remove('show');
                        setTimeout(() => {
                            modal.style.display = 'none';
                        }, 300);
                        document.body.style.overflow = 'auto';
                    }
                }
            });
            
            // 更新模态框显示
            function updateModal() {
                modalImage.classList.remove('loaded');
                
                const loadImage = new Image();
                loadImage.src = currentImages[currentIndex];
                loadImage.onload = function() {
                    modalImage.src = currentImages[currentIndex];
                    modalImage.classList.add('loaded');
                };
                
                // 更新激活的缩略图
                document.querySelectorAll('.modal-thumbnail').forEach((thumb, index) => {
                    thumb.className = 'modal-thumbnail' + (index === currentIndex ? ' active' : '');
                });
            }
            
            // 初始化PJAX支持
            if (typeof window.$ !== 'undefined' && typeof window.$.pjax === 'function') {
                $(document).on('pjax:complete', function() {
                    // 重新绑定事件
                    bindPhotoCardEvents();
                    initAnimations();
                });
            }
        });
    </script>
</body>
</html>