$(document).ready(function() {
    $('.buttonShowDetailInformation').on('click', function() {
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

        $('#detailInformationAvatar').attr('src', avatar)
        $('#detailInformationEmail').val(email);
        $('#detailInformationUsername').val(username);
        $('#detailInformationName').val(name);
        $('#detailInformationIdentityNumber').val(identityNumber);
        $('#detailInformationPhone').val(phone);
        $('#detailInformationAddress').val(address);
        $('#detailInformationGender').val(isFemale);
        $('#detailInformationDateOfBirth').val(dateOfBirth);

        $('#userDetailModal').modal('show');
    });
});