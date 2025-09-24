document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            this.classList.add('active');
            const targetContent = document.getElementById(targetTab);
            if (targetContent) {
                targetContent.classList.add('active');
            }
        });
    });
    
    const addReviewBtn = document.getElementById('add-review-btn');
    const reviewFormContainer = document.getElementById('review-form-container');
    const closeReviewForm = document.getElementById('close-review-form');
    const cancelReview = document.getElementById('cancel-review');
    
    if (addReviewBtn && reviewFormContainer) {
        addReviewBtn.addEventListener('click', function() {
            reviewFormContainer.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
        
        function hideReviewForm() {
            reviewFormContainer.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        if (closeReviewForm) {
            closeReviewForm.addEventListener('click', hideReviewForm);
        }
        
        if (cancelReview) {
            cancelReview.addEventListener('click', hideReviewForm);
        }

        reviewFormContainer.addEventListener('click', function(e) {
            if (e.target === reviewFormContainer) {
                hideReviewForm();
            }
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && reviewFormContainer.style.display === 'flex') {
                hideReviewForm();
            }
        });
    }
    
  const loadMoreBtn = document.getElementById('load-more-btn');
const loadMoreSection = document.getElementById('load-more-section');
const hiddenReviews = document.querySelectorAll('.hidden-review');
const initialReviews = 3; 
let currentDisplayed = initialReviews;
const reviewsPerLoad = 5;
const totalReviews = hiddenReviews.length + 3;

if (totalReviews < 3) {
    loadMoreSection.style.display = 'none';
}

if (loadMoreBtn && hiddenReviews.length > 0) {
    loadMoreBtn.addEventListener('click', function() {
        let reviewsToShow = Math.min(reviewsPerLoad, hiddenReviews.length - (currentDisplayed - 3));
        let startIndex = currentDisplayed - 3;

        for (let i = startIndex; i < startIndex + reviewsToShow; i++) {
            if (hiddenReviews[i]) {
                hiddenReviews[i].style.display = 'block';
                hiddenReviews[i].style.opacity = '0';
                hiddenReviews[i].style.transform = 'translateY(20px)';

                setTimeout((function(review) {
                    return function() {
                        review.style.transition = 'all 0.5s ease';
                        review.style.opacity = '1';
                        review.style.transform = 'translateY(0)';
                    };
                })(hiddenReviews[i]), i * 100);
            }
        }
        
        currentDisplayed += reviewsToShow;
    
        const remainingReviews = totalReviews - currentDisplayed;
        if (remainingReviews > 0) {
            loadMoreBtn.textContent = `Xem thêm đánh giá (${remainingReviews})`;
        } else {
            loadMoreBtn.textContent = 'Đã hiển thị tất cả đánh giá';
            loadMoreBtn.disabled = true;
            loadMoreBtn.style.opacity = '0.6';
            loadMoreBtn.style.cursor = 'not-allowed';
        }
    });
}
});