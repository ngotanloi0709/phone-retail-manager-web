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

$(document).ready(function () {
    $('.buttonShowDetailInformation').on('click', function () {
        let currentRow = $(this).closest('tr');
        let avatar = $(currentRow).data('user-avatar');
        let email = $(currentRow).data('user-email');
        let username = $(currentRow).data('user-username');
        let name = $(currentRow).data('user-name');
        let identityNumber = $(currentRow).data('user-identity-number');
        let phone = $(currentRow).data('user-phone');
        let address = $(currentRow).data('user-address');
        let isFemale = $(currentRow).data('user-is-female');
        let dateOfBirth = $(currentRow).data('user-date-of-birth');
        let role = $(currentRow).data('user-role');
        let isLocked = $(currentRow).data('user-is-locked');

        $('#detailInformationAvatar').attr('src', avatar)
        $('#detailInformationEmail').val(email);
        $('#detailInformationUsername').val(username);
        $('#detailInformationName').val(name);
        $('#detailInformationIdentityNumber').val(identityNumber);
        $('#detailInformationPhone').val(phone);
        $('#detailInformationAddress').val(address);
        $('#detailInformationGender').val(isFemale);
        $('#detailInformationDateOfBirth').val(dateOfBirth);
        $('#detailInformationIsLocked').val(isLocked);

        if (role === 'admin') {
            $('#detailInformationRole').val('Quản trị viên');
        } else if (role === 'user') {
            $('#detailInformationRole').val('Nhân viên bán hàng');
        }

        $('#userDetailModal').modal('show');
    });

    $('.buttonShowSendLoginEmailConfirmation').on('click', function () {
        let currentRow = $(this).closest('tr');
        let username = $(currentRow).data('user-username');
        let email = $(currentRow).data('user-email');

        $('#inputEmailSendLoginEmailConfirmModal').val(email);
        $('#usernameSendLoginEmailConfirmModal').text(username);
        $('#sendLoginEmailConfirmModal').modal('show');
    });

    $('.buttonDeleteUserInformation').on('click', function () {
        let currentRow = $(this).closest('tr');
        let username = $(currentRow).data('user-username');
        let id = $(currentRow).data('user-id');

        $('#idDeleteUserConfirmModal').val(id);
        $('#usernameDeleteUserConfirmModal').text(username);
        $('#deleteUserConfirmModal').modal('show');
    });

    $('.buttonEditUserInformation').on('click', function () {
        let currentRow = $(this).closest('tr');
        let avatar = $(currentRow).data('user-avatar');
        let email = $(currentRow).data('user-email');
        let username = $(currentRow).data('user-username');
        let name = $(currentRow).data('user-name');
        let identityNumber = $(currentRow).data('user-identity-number');
        let phone = $(currentRow).data('user-phone');
        let address = $(currentRow).data('user-address');
        let isFemale = $(currentRow).data('user-is-female-bool');
        let dateOfBirth = $(currentRow).data('user-date-of-birth');
        let role = $(currentRow).data('user-role');
        let isLocked = $(currentRow).data('user-is-locked-bool');
        let id = $(currentRow).data('user-id');

        $('#editUserInformationId').val(id)
        $('#editUserInformationDisplayAvatar').attr('src', avatar)
        $('#editUserInformationAvatar').val(avatar)
        $('#editUserInformationEmail').val(email);
        $('#editUserInformationUsername').val(username);

        if (name === 'Chưa có dữ liệu') {
            $('#editUserInformationName').val("");
        } else {
            $('#editUserInformationName').val(name);
        }

        if (identityNumber === 'Chưa có dữ liệu') {
            $('#editUserInformationIdentityNumber').val("");
        } else {
            $('#editUserInformationIdentityNumber').val(identityNumber);
        }

        if (phone === 'Chưa có dữ liệu') {
            $('#editUserInformationPhone').val("");
        } else {
            $('#editUserInformationPhone').val(phone);
        }

        if (address === 'Chưa có dữ liệu') {
            $('#editUserInformationAddress').val("");
        } else {
            $('#editUserInformationAddress').val(address);
        }

        if (isFemale) {
            $('#editUserInformationGenderFemale').prop('checked', true);
        } else {
            $('#editUserInformationGenderMale').prop('checked', true);
        }

        let dateParts = dateOfBirth.split("-");
        let dateObject = new Date(Date.UTC(+dateParts[2], dateParts[1] - 1, +dateParts[0]));
        let formattedDate = dateObject.toISOString().split('T')[0];
        $('#editUserInformationDateOfBirth').val(formattedDate);

        if (role === 'admin') {
            $('#editUserInformationRole').val('admin');
        } else if (role === 'user') {
            $('#editUserInformationRole').val('user');
        }

        if (isLocked) {
            $('#editUserInformationIsLocked').val("1");
        } else {
            $('#editUserInformationIsLocked').val("0");
        }

        document.getElementById('inputAvatar').addEventListener('change', function (e) {
            let reader = new FileReader();

            // Resize/Compress the image
            reader.onload = function (e) {
                downScaleImage(e.target.result, 500, undefined, undefined, function(newDataUrl) {
                    document.getElementById('editUserInformationDisplayAvatar').src = newDataUrl;

                    let avatarInput = document.getElementById('editUserInformationAvatar')
                    avatarInput.value = newDataUrl;
                });
            }

            reader.readAsDataURL(this.files[0]);
        });

        $('#editUserInformationModal').modal('show');
    });

    $('.buttonChangeUserPassword').on('click', function () {
        let currentRow = $(this).closest('tr');
        let id = $(currentRow).data('user-id');
        let username = $(currentRow).data('user-username');

        $('#changePasswordModalId').val(id);
        $('#changeUserPasswordModalLabel').text('Đổi mật khẩu cho tài khoản ' + username);
        $('#changeUserPasswordModal').modal('show');
    });
});
