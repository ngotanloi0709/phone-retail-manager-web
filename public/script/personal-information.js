// Compress image
function downScaleImage(dataUrl, newWidth, imageType, imageArguments, callback) {
    "use strict";
    let image, oldWidth, oldHeight, newHeight, canvas, ctx, newDataUrl;

    // Provide default values
    imageType = imageType || "image/jpeg";
    imageArguments = imageArguments || 0.7;

    // Create a temporary image so that we can compute the height of the downscaled image.
    image = new Image();
    image.onload = function() {
        oldWidth = image.width;
        oldHeight = image.height;
        newHeight = Math.floor(oldHeight / oldWidth * newWidth)

        // Create a temporary canvas to draw the downscaled image on.
        canvas = document.createElement("canvas");
        canvas.width = newWidth;
        canvas.height = newHeight;

        // Draw the downscaled image on the canvas and return the new data URL.
        ctx = canvas.getContext("2d");
        ctx.drawImage(image, 0, 0, newWidth, newHeight);
        newDataUrl = canvas.toDataURL(imageType, imageArguments);

        // Call the callback with the new data URL
        callback(newDataUrl);
    };

    // Start loading the image.
    image.src = dataUrl;
}

document.getElementById('inputAvatar').addEventListener('change', function (e) {
    let reader = new FileReader();

    // Resize/Compress the image
    reader.onload = function (e) {
        downScaleImage(e.target.result, 500, undefined, undefined, function(newDataUrl) {
            document.getElementById('displayAvatar').src = newDataUrl;

            // Submit the form with the new image
            let newInput = document.createElement('input');
            newInput.type = 'hidden';
            newInput.name = 'avatar';
            newInput.value = newDataUrl;
            document.getElementById('changeAvatarForm').appendChild(newInput);

            document.getElementById('changeAvatarForm').submit();
        });
    }

    reader.readAsDataURL(this.files[0]);
});