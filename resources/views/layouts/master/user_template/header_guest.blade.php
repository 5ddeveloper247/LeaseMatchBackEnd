@php
use Carbon\Carbon;

@endphp

<header>
    <div class="contain-fluid">
       
    </div>
</header>
<!-- header -->
<style scoped>
    @media (max-width: 320px) {
        aside {

            width: 42%;
        }
    }

    .show-small {
        display: none;
    }


    @media (max-width: 557px) {
        .show-small {
            display: block;
        }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.mark-as-read').forEach(button => {
        button.addEventListener('click', function () {
            const notificationId = this.dataset.id;


            fetch(`/customer/notifications/mark-as-read/${notificationId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ id: notificationId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.remove(); // Remove the button after marking as read
                    toastr.success(data.message,'Success!',{
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-top-center',
                        timeOut: 5000,
                        extendedTimeOut: 3000,
                    });
                } else {
                   toastr.error(data.message,'Error',{
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-center',
                    timeOut: 5000,
                    extendedTimeOut: 3000,
                   })
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});

</script>
