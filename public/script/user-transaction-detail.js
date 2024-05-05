$(document).ready(function () {
    $('.buttonShowTransactionDetail').on('click', function () {
        // Get transaction details from data-transaction-details attribute
        let transactionDetails = JSON.parse($(this).parent().parent().attr('data-transaction-details'));
        let transactionCreatedDate = $(this).parent().parent().attr('data-transaction-created');
        // Create new tr elements for transaction detail table
        let newRows = transactionDetails.map(function (detail) {
            return '<tr><td>' + detail.productName + '</td><td>' + detail.quantity + '</td><td>' + detail.price + '</td></tr>';
        }).join('');

        // Clear current content of transaction detail table and append new tr elements
        $('.transactionDetailTableBody').empty().append(newRows);

        // Update other fields in the modal
        $('#transactionDetailId').text($(this).parent().siblings().eq(0).text());
        $('#transactionDetailUserName').text($(this).parent().siblings().eq(1).text());
        $('#transactionDetailCustomerName').text($(this).parent().siblings().eq(2).text());
        $('#transactionDetailCustomerPhone').text($(this).parent().siblings().eq(3).text());
        $('#transactionDetailDateCreated').text(transactionCreatedDate);
        $('#transactionDetailStatus').text($(this).parent().siblings().eq(4).text());
        $('#transactionDetailTotal').text($(this).parent().siblings().eq(6).text());

        // Show the modal
        $('#userTransactionDetailModal').modal('show');
    });
});