document.addEventListener("DOMContentLoaded", function () {
    const startWorkBtn = document.getElementById("start-work");
    const endWorkBtn = document.getElementById("end-work");
    const startBreakBtn = document.getElementById("start-break");
    const endBreakBtn = document.getElementById("end-break");

    startWorkBtn.addEventListener("click", function (event) {
        event.preventDefault();
        fetch('/start-work', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
            .then(response => window.location.reload())
            .catch(error => console.error(error));
    });

    endWorkBtn.addEventListener("click", function (event) {
        event.preventDefault();
        fetch('/end-work', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
            .then(response => window.location.reload())
            .catch(error => console.error(error));
    });

    startBreakBtn.addEventListener("click", function (event) {
        event.preventDefault();
        fetch('/start-break', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
            .then(response => window.location.reload())
            .catch(error => console.error(error));
    });

    endBreakBtn.addEventListener("click", function (event) {
        event.preventDefault();
        fetch('/end-break', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
            .then(response => window.location.reload())
            .catch(error => console.error(error));
    });
});
