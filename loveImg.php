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
    <script src="Style/js/loveImg.js?LikeGirl=<?php echo $version ?>" defer></script>
</head>

<body>
    <div id="pjax-container">
        <h4 class="text-ce central fade-in">记录下你的最美瞬间</h4>
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
    
    <?php include_once 'footer.php'; ?>
</body>
</html>