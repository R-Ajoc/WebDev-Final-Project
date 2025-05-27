document.addEventListener('DOMContentLoaded', () => {
  const openPopupBtn = document.getElementById('openPopup');
  const popupForm = document.getElementById('popupForm');
  const closeBtn = document.querySelector('.close-btn');

  console.log('Script loaded: openPopupBtn =', openPopupBtn, 'popupForm =', popupForm);

  popupForm.style.display = 'none';

  openPopupBtn.addEventListener('click', () => {
    console.log('Add Product button clicked');
    popupForm.style.display = 'block';
  });

  closeBtn.addEventListener('click', () => {
    console.log('Close button clicked');
    popupForm.style.display = 'none';
  });

  window.addEventListener('click', (event) => {
    if (event.target === popupForm) {
      console.log('Overlay clicked');
      popupForm.style.display = 'none';
    }
  });
});
