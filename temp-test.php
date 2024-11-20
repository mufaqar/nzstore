<?php /* Template Name: Test  */ 
        get_header();
       // reddirectProfile();
                ?> 
 <div class="container mt-5">
    <h3>Search Repairs</h3>
    <div class="form-group position-relative">
        <input type="text" id="repair-search" class="form-control" placeholder="Search for repairs...">
        <div class="dropdown mt-1 w-100">
            <ul class="dropdown-menu w-100" id="search-results" style="display: none;"></ul>
        </div>
    </div>
</div>
    <?php get_footer();?>

    <script>
    jQuery(document).ready(function ($) {
        // Perform AJAX search on input
        $('#repair-search').on('input', function () {
            let searchTerm = $(this).val();

            if (searchTerm.length < 3) {
                $('#search-results').hide();
                return;
            }

            $.ajax({
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                method: 'GET',
                data: {
                    action: 'search_repair_posts',
                    search_term: searchTerm,
                },
                success: function (data) {
                    let resultsContainer = $('#search-results');
                    resultsContainer.empty();

                    if (data.length > 0) {
                        data.forEach(item => {
                            resultsContainer.append(
                                `<li class="dropdown-item" data-id="${item.id}">${item.title}</li>`
                            );
                        });
                        resultsContainer.show();
                    } else {
                        resultsContainer.append(`<li class="dropdown-item text-muted">No results found</li>`);
                        resultsContainer.show();
                    }
                },
            });
        });

        // Handle selection of a result
        $(document).on('click', '#search-results .dropdown-item', function () {
            let selectedTitle = $(this).text();
            let selectedId = $(this).data('id');

            // Show selected value in the input field
            $('#repair-search').val(selectedTitle);

            // Hide dropdown
            $('#search-results').hide();

            // Optionally, perform another action with the selectedId (e.g., redirect)
            console.log(`Selected Post ID: ${selectedId}`);
        });
    });
</script>
    
