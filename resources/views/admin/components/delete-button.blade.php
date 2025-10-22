<script>
    $('.delete-button').on('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $(this).data('url'),
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire("Deleted!", response.message, "success");
                        } else {
                            Swal.fire("Error!", response.message, "error");
                        }
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function () {
                        Swal.fire("Error!", "Something went wrong with the request.", "error");
                    }
                });
            }
        });
    });
</script>