
document.addEventListener("DOMContentLoaded", function() {
    flatpickr("#datetime-picker", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
        minuteIncrement: 1,
        minTime: "09:00", // Chỉ làm việc từ 9h buổi sáng đến 18 giờ buổi tối
        maxTime: "18:00",
        disable: [
            function(date) {
                // Bỏ qua ngày chủ nhật
                return date.getDay() === 0;
            }
        ],
    });
});
