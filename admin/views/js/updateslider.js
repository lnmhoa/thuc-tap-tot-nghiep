var reader = new FileReader();
for(let i = 1; i <= 6 ; i++){
    document.querySelector('#newSlider'+i).addEventListener('change', function(event) {
        var file = event.target.files[0];
        reader.onload = function(event) {
          var imageUrl = event.target.result;
          var img = document.createElement('img');
          img.src = imageUrl;
          var imageContainer = document.querySelector('#imgContainer'+i);
          var oldimg = document.querySelector('#oldimg'+i);
          oldimg.style.display="none";
          imageContainer.innerHTML = '';
          imageContainer.appendChild(img);
        };
        reader.readAsDataURL(file);
      });
}
