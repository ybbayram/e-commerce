$(window).on('load', function() {
    setTimeout(function() {
        $('#exampleModal').modal('show');
    }, 2500);
});
function openSearch() {
    document.getElementById("search-overlay").style.display = "block";
    document.getElementById("mobile-wishlist").style.display = "none";
 
}
 
function closeSearch() {
    document.getElementById("search-overlay").style.display = "none";
    document.getElementById("mobile-wishlist").style.display = "block";
 
} 