//社区版1.0.0版本在测试时，恋爱相册界面有个顽强的BUG，首次进入页面不刷新就不给显示卡片，但F12显示CSS以及内容已经加载了，就是前端莫名其妙不显示
//后来发现把动画效果禁掉就恢复了，但重新审查后发现代码没问题，后来没辙了，就把js内容移到了外部文件，再进行单独测试排查
//该BUG已在1.0.1版本修复了

function initLoveGallery() {
    // 安全获取元素函数
    const getElement = (id) => {
        const el = document.getElementById(id);

        return el;
    };

    // 获取所有必需元素
    const elements = {
        modal: getElement('imageModal'),
        modalImage: getElement('modalImage'),
        closeModal: getElement('closeModal'),
        prevArrow: getElement('prevArrow'),
        nextArrow: getElement('nextArrow'),
        modalThumbnailsContainer: getElement('modalThumbnailsContainer'),
        modalDescription: getElement('modalDescription'),
        modalDate: getElement('modalDate')
    };

    let currentImages = [];
    let currentIndex = 0;

    // 初始化动画效果
    const initAnimations = () => {
        const photoItems = document.querySelectorAll('.photo-item');
        photoItems.forEach(item => {
            item.classList.add('show');
        });
    };

    // 更新模态框显示
    const updateModal = () => {
        elements.modalImage.classList.remove('loaded');
        
        const loadImage = new Image();
        loadImage.src = currentImages[currentIndex];
        loadImage.onload = () => {
            elements.modalImage.src = currentImages[currentIndex];
            elements.modalImage.classList.add('loaded');
            
            // 更新激活的缩略图
            document.querySelectorAll('.modal-thumbnail').forEach((thumb, index) => {
                thumb.className = 'modal-thumbnail' + (index === currentIndex ? ' active' : '');
            });
        };
    };

    // 绑定照片卡片点击事件
    const bindPhotoCardEvents = () => {
        document.querySelectorAll('.photo-card').forEach(card => {
            card.addEventListener('click', function(e) {
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
                    // 显示模态框
                    elements.modal.style.display = 'flex';
                    setTimeout(() => {
                        elements.modal.classList.add('show');
                    }, 10);
                    
                    elements.modalImage.classList.remove('loaded');
                    
                    // 预加载图片
                    const loadImage = new Image();
                    loadImage.src = currentImages[currentIndex];
                    loadImage.onload = () => {
                        elements.modalImage.src = currentImages[currentIndex];
                        elements.modalImage.classList.add('loaded');
                    };
                    
                    elements.modalDescription.textContent = description;
                    elements.modalDate.textContent = date;
                    
                    // 创建缩略图
                    elements.modalThumbnailsContainer.innerHTML = '';
                    currentImages.forEach((url, index) => {
                        const thumbnail = document.createElement('img');
                        thumbnail.src = url;
                        thumbnail.className = 'modal-thumbnail' + (index === currentIndex ? ' active' : '');
                        thumbnail.addEventListener('click', (e) => {
                            e.stopPropagation();
                            currentIndex = index;
                            updateModal();
                        });
                        elements.modalThumbnailsContainer.appendChild(thumbnail);
                    });
                    
                    document.body.style.overflow = 'hidden';
                }
            });
        });
    };

    // 绑定模态框事件
    const bindModalEvents = () => {
        // 关闭模态框
        elements.closeModal.addEventListener('click', () => {
            elements.modal.classList.remove('show');
            setTimeout(() => {
                elements.modal.style.display = 'none';
            }, 300);
            document.body.style.overflow = 'auto';
        });

        // 点击背景关闭
        elements.modal.addEventListener('click', (e) => {
            if (e.target === elements.modal) {
                elements.modal.classList.remove('show');
                setTimeout(() => {
                    elements.modal.style.display = 'none';
                }, 300);
                document.body.style.overflow = 'auto';
            }
        });

        // 导航箭头
        elements.prevArrow.addEventListener('click', (e) => {
            e.stopPropagation();
            if (currentImages.length > 1) {
                currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
                updateModal();
            }
        });

        elements.nextArrow.addEventListener('click', (e) => {
            e.stopPropagation();
            if (currentImages.length > 1) {
                currentIndex = (currentIndex + 1) % currentImages.length;
                updateModal();
            }
        });

        // 键盘导航
        document.addEventListener('keydown', (e) => {
            if (elements.modal.classList.contains('show')) {
                if (e.key === 'ArrowLeft') {
                    currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
                    updateModal();
                } else if (e.key === 'ArrowRight') {
                    currentIndex = (currentIndex + 1) % currentImages.length;
                    updateModal();
                } else if (e.key === 'Escape') {
                    elements.modal.classList.remove('show');
                    setTimeout(() => {
                        elements.modal.style.display = 'none';
                    }, 300);
                    document.body.style.overflow = 'auto';
                }
            }
        });
    };

    // 执行初始化(立即)
    initAnimations();
    bindPhotoCardEvents();
    bindModalEvents();
}

// 标准初始化
document.addEventListener('DOMContentLoaded', initLoveGallery);

// PJAX兼容处理
if (typeof window.$ !== 'undefined' && typeof window.$.pjax === 'function') {
    $(document).on('pjax:complete', initLoveGallery);
}