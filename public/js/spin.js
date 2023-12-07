function create_spinner(totalBooth) {
    var color_data = ['#fedf30', '#fdb441', '#fd6930', '#eb5454', '#bf9dd3', '#29b8cd', "#00f2a6"];
    var label_data = Array.from({ length: totalBooth }, (_, i) => (i + 1).toString());
    var color = color_data;
    var label = label_data;
    var slices = color.length
    var sliceDeg = 360 / slices;
    var deg = rand(0, 360);
    var speed = 10;
    var slowDownRand = 0;
    var ctx = canvas.getContext('2d');
    var width = canvas.width; // size
    var center = width / 2; // center
    ctx.clearRect(0, 0, width, width);
    for (var i = 0; i < slices; i++) {
        ctx.beginPath();
        ctx.fillStyle = color[i];
        ctx.moveTo(center, center);
        ctx.arc(center, center, width / 2, deg2rad(deg), deg2rad(deg + sliceDeg));
        ctx.lineTo(center, center);
        ctx.fill();
        var drawText_deg = deg + sliceDeg / 2;
        ctx.save();
        ctx.translate(center, center);
        ctx.rotate(deg2rad(drawText_deg));
        ctx.textAlign = "right";
        ctx.fillStyle = "#fff";
        ctx.font = 'bold 15px sans-serif';
        ctx.fillText(label[i], 100, 5);
        ctx.restore();
        deg += sliceDeg;
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Mendapatkan ID acara dari beberapa cara yang sesuai dengan kebutuhan Anda
        var eventId = 1;  // Gantilah dengan ID acara yang sesuai
        // Mengambil total_booth dari server
        fetch(`/get-total-booth/${eventId}`)
            .then(response => response.json())
            .then(data => {
                if (data.total_booth) {
                    // Menggunakan total_booth untuk membuat spinner
                    create_spinner(data.total_booth);
                } else {
                    console.error('Total Booth not available.');
                }
            })
            .catch(error => {
                console.error('Error fetching total_booth:', error);
            });
    });

}
create_spinner();
var deg = rand(0, 360);
var speed = 10;
var ctx = canvas.getContext('2d');
var width = canvas.width; // size
var center = width / 2; // center
var isStopped = false;
var lock = false;
var slowDownRand = 0;

function spin(totalBooth) {
    color_data = ['#fedf30', '#fdb441', '#fd6930', '#eb5454', '#bf9dd3', '#29b8cd', "#00f2a6"];
    var label_data = Array.from({ length: totalBooth }, (_, i) => (i + 1).toString());
    var color = color_data;
    var label = label_data;
    var slices = color.length;
    var sliceDeg = 360 / slices;
    deg += speed;
    deg %= 360;

    // Increment speed
    if (!isStopped && speed < 3) {
        speed = speed + 1 * 0.1;
    }

    // Decrement Speed
    if (isStopped) {
        if (!lock) {
            lock = true;
            slowDownRand = rand(0.994, 0.998);
        }
        speed = speed > 0.2 ? speed *= slowDownRand : 0;
    }

    // Stopped!
    if (lock && !speed) {
        var ai = Math.floor(((360 - deg - 90) % 360) / sliceDeg); // deg 2 Array Index
        ai = (slices + ai) % slices; // Fix negative index

        return swal({
            title: "Anda Mendapatkan Nomor Lapak!!!!",
            text: " " + label[ai] + "",
            type: "success",
            confirmButtonText: "OK",
            closeOnConfirm: false
        });
    }

    ctx.clearRect(0, 0, width, width);
    for (var i = 0; i < slices; i++) {
        ctx.beginPath();
        ctx.fillStyle = color[i];
        ctx.moveTo(center, center);
        ctx.arc(center, center, width / 2, deg2rad(deg), deg2rad(deg + sliceDeg));
        ctx.lineTo(center, center);
        ctx.fill();

        var drawText_deg = deg + sliceDeg / 2;
        ctx.save();
        ctx.translate(center, center);
        ctx.rotate(deg2rad(drawText_deg));
        ctx.textAlign = "right";
        ctx.fillStyle = "#fff";
        ctx.font = 'bold 15px sans-serif';
        ctx.fillText(label[i], 100, 5);
        ctx.restore();
        deg += sliceDeg;
    }

    window.requestAnimationFrame(function () {
        spin(totalBooth);
    });
}

function stops() {
    isStopped = true;
}

function deg2rad(deg) {
    return deg * Math.PI / 180;
}

function rand(min, max) {
    return Math.random() * (max - min) + min;
}

create_spinner(totalBooth);
