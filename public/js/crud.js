
function store(url, data) {
    axios.post(url, data)
        .then(function (response) {
            console.log(response);
            if (document.getElementById('create_form') != undefined)
                document.getElementById('create_form').reset();
            showToaster(response.data.message, true);
        })
        .catch(function (error) {
            console.log(error.response);
            showToaster(error.response.data.message, false);
        });
}

function update(url, data, redirectUrl) {
    axios.put(url, data)
        .then(function (response) {
            console.log(response);
            window.location.href = redirectUrl;
        })
        .catch(function (error) {
            console.log(error.response);
            showToaster(error.response.data.message, false);
        });
}

function confirmDestroy(url, td) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            destroy(url, td);
        }
    });
}

function destroy(url, td) {
    axios.delete(url)
        .then(function (response) {
            // handle success
            console.log(response.data);
            td.closest('tr').remove();
            showAlert(response.data);
        })
        .catch(function (error) {
            // handle error
            console.log(error.response);
            showAlert(error.response.data);
        })
        .then(function () {
            // always executed
        });
}

function showToaster(message, status) {
    if (status) {
        toastr.success(message);
    } else {
        toastr.error(message);
    }
}

function showAlert(data) {
    Swal.fire({
        title: data.title,
        text: data.message,
        icon: data.icon,
        timer: 2000,
        showConfirmButton: false,
        timerProgressBar: false,
        willOpen: () => {
            // Swal.showLoading()
        },
        willClose: () => {

        }
    }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
        }
    });
}
