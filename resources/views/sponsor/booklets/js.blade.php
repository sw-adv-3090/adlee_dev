<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('#select-all').on('change', function(e) {
            if (e.target.checked) {
                $('.all-check').prop('checked', true);
            } else {
                $('.all-check').prop('checked', false);
            }

            handleBulkSelection();

        });

        $('.all-check').on('change', function() {
            handleBulkSelection();
        })

        function handleBulkSelection() {
            const bookletIds = $(".all-check:checked").map(function() {
                return $(this).val();
            }).get();

            if (bookletIds.length > 0) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('sponsors.bulk-url') }}",
                    data: {
                        type: "booklets",
                        bookletIds
                    },
                    success: function(response) {
                        $('#bulkActivate').removeClass('hidden').attr("href", response.activate);
                    },
                    error: function(data) {
                        console.log("38");
                    }
                });

            } else {
                $('#bulkActivate').addClass('hidden');
                // $('#bulkPayout').addClass('hidden');
            }
        }
    });
</script>
