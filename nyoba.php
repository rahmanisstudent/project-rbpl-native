<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Tanggal Pengerjaan Pakaian</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            padding: 20px;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .date-picker {
            position: relative;
        }

        .date-input {
            width: 100%;
            padding: 15px;
            border: none;
            background: #4a5568;
            color: white;
            font-size: 16px;
            cursor: pointer;
            position: relative;
        }

        .date-input:after {
            content: '▼';
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
        }

        .calendar-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #4a5568;
            border-radius: 0 0 10px 10px;
            z-index: 1000;
            display: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            min-height: 300px;
            position: relative;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #4a5568;
            color: white;
        }

        .nav-btn {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 3px;
        }

        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .month-year {
            font-weight: bold;
            font-size: 16px;
        }

        .calendar-grid {
            padding: 0 15px 60px 15px;
        }

        .weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            margin-bottom: 5px;
        }

        .weekday {
            padding: 8px;
            text-align: center;
            font-size: 12px;
            color: #a0aec0;
            font-weight: bold;
        }

        .days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            position: relative;
            overflow: hidden;
            transition: all 0.2s;
        }

        .day {
            width: 41px;             
            height: 41px;               
            padding: 0;
            margin: 2px;
            text-align: left;
            color: white;
            cursor: pointer;
            border-radius: 8px;
            font-size: 18px;          
            transition: all 0.2s;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
            min-height: 56px;
            box-sizing: border-box;
        }

        .day:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .day.other-month {
            color: #718096;
        }

        .day.selected {
            background: #38b2ac;
            color: white;
            font-weight: bold;
        }

        .day.today {
            background: rgba(56, 178, 172, 0.3);
        }

        .confirm-btn {
            position: absolute;
            bottom: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            background: #38b2ac;
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .confirm-btn:hover {
            background: #319795;
        }

        .order-indicators {
            display: flex;
            gap: 2px;
            margin-top: auto;
            margin-left: 8px;
            margin-bottom: 6px;
            justify-content: flex-start;
            flex-wrap: wrap;
            max-width: 100%;
            min-height: 8px;
        }

        .day-number {
            font-size: 18px;
            font-weight: bold;
            margin: 6px 0 0 8px;
            line-height: 1;
            color: inherit;
        }

        .order-line {
            position: absolute;
            height: 3px;
            border-radius: 1.5px;
            z-index: 1;
            pointer-events: none;
        }

        .order-line.red { background-color: #e53e3e; }
        .order-line.blue { background-color: #3182ce; }
        .order-line.green { background-color: #38a169; }
        .order-line.yellow { background-color: #d69e2e; }
        .order-line.purple { background-color: #805ad5; }
        .order-line.orange { background-color: #dd6b20; }
        .order-line.pink { background-color: #d53f8c; }
        .order-line.cyan { background-color: #0987a0; }

        .form-section {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #2d3748;
        }

        .selected-date {
            color: #38b2ac;
            font-weight: bold;
        }

        /* Order Details Modal */
        .order-details-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }

        .order-details-content {
            background: white;
            border-radius: 10px;
            padding: 20px;
            max-width: 400px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }

        .modal-title {
            font-size: 18px;
            font-weight: bold;
            color: #2d3748;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #718096;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .close-btn:hover {
            background: #f7fafc;
            color: #2d3748;
        }

        .order-item {
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            border-left: 4px solid;
            background: #f7fafc;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .order-item.red { border-left-color: #e53e3e; }
        .order-item.blue { border-left-color: #3182ce; }
        .order-item.green { border-left-color: #38a169; }
        .order-item.yellow { border-left-color: #d69e2e; }
        .order-item.purple { border-left-color: #805ad5; }
        .order-item.orange { border-left-color: #dd6b20; }
        .order-item.pink { border-left-color: #d53f8c; }
        .order-item.cyan { border-left-color: #0987a0; }

        .order-customer {
            font-weight: bold;
            color: #2d3748;
            font-size: 16px;
        }

        .order-type {
            color: #4a5568;
            font-size: 14px;
        }

        .order-duration {
            color: #718096;
            font-size: 12px;
            font-style: italic;
        }

        .no-orders {
            text-align: center;
            color: #718096;
            font-style: italic;
            padding: 20px;
        }

        .order-status {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-ongoing {
            background: #fed7d7;
            color: #c53030;
        }

        .status-starting {
            background: #c6f6d5;
            color: #2f855a;
        }

        .status-ending {
            background: #fefcbf;
            color: #d69e2e;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-section">
            <h2 style="margin-bottom: 20px; color: #2d3748;">Form Pengerjaan Pakaian</h2>
            
            <div class="form-group">
                <label>Pilih Tanggal Pengerjaan:</label>
                <div class="date-picker">
                    <div class="date-input" onclick="toggleCalendar('start')">
                        <span id="selectedStartDateText">Pilih Tanggal Pengerjaan</span>
                    </div>
                    
                    <div class="calendar-dropdown" id="startCalendarDropdown">
                        <div class="calendar-header">
                            <button class="nav-btn" onclick="previousMonth()">‹</button>
                            <span class="month-year" id="startMonthYear"></span>
                            <button class="nav-btn" onclick="nextMonth()">›</button>
                        </div>
                        <div class="calendar-grid">
                            <div class="weekdays">
                                <div class="weekday">SEN</div>
                                <div class="weekday">SEL</div>
                                <div class="weekday">RAB</div>
                                <div class="weekday">KAM</div>
                                <div class="weekday">JUM</div>
                                <div class="weekday">SAB</div>
                                <div class="weekday">MIN</div>
                            </div>
                            <div class="days" id="startDaysContainer"></div>
                        </div>
                        <button class="confirm-btn" onclick="confirmDate('start')">✓</button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Pilih Tanggal Penyelesaian:</label>
                <div class="date-picker">
                    <div class="date-input" onclick="toggleCalendar('end')">
                        <span id="selectedEndDateText">Pilih Tanggal Penyelesaian</span>
                    </div>
                    
                    <div class="calendar-dropdown" id="endCalendarDropdown">
                        <div class="calendar-header">
                            <button class="nav-btn" onclick="previousMonth()">‹</button>
                            <span class="month-year" id="endMonthYear"></span>
                            <button class="nav-btn" onclick="nextMonth()">›</button>
                        </div>
                        <div class="calendar-grid">
                            <div class="weekdays">
                                <div class="weekday">SEN</div>
                                <div class="weekday">SEL</div>
                                <div class="weekday">RAB</div>
                                <div class="weekday">KAM</div>
                                <div class="weekday">JUM</div>
                                <div class="weekday">SAB</div>
                                <div class="weekday">MIN</div>
                            </div>
                            <div class="days" id="endDaysContainer"></div>
                        </div>
                        <button class="confirm-btn" onclick="confirmDate('end')">✓</button>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Tanggal Terpilih:</label>
                <div class="selected-date" id="displaySelectedDates">Belum dipilih</div>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div class="order-details-modal" id="orderDetailsModal">
        <div class="order-details-content">
            <div class="modal-header">
                <div class="modal-title" id="modalTitle">Pesanan Tanggal</div>
                <button class="close-btn" onclick="closeOrderDetails()">&times;</button>
            </div>
            <div id="orderDetailsList"></div>
        </div>
    </div>

    <script>
        let currentDate = new Date(2025, 5, 1); // Default ke Juni 2025
        let selectedStartDate = null;
        let selectedEndDate = null;
        let tempSelectedDate = null;
        let activeCalendar = 'start';

        const orderData = [
            {id: 1, customer: 'Mas Amba', type: 'Kemeja', color: 'red', startDate: '2025-06-01', endDate: '2025-06-11'},
            {id: 2, customer: 'Bu Sari', type: 'Dress', color: 'blue', startDate: '2025-06-03', endDate: '2025-06-08'},
            {id: 3, customer: 'Pak Budi', type: 'Celana', color: 'green', startDate: '2025-06-10', endDate: '2025-06-15'},
            {id: 4, customer: 'Mbak Rina', type: 'Blouse', color: 'yellow', startDate: '2025-06-12', endDate: '2025-06-18'},
            {id: 5, customer: 'Mas Doni', type: 'Jaket', color: 'purple', startDate: '2025-06-16', endDate: '2025-06-22'},
            {id: 6, customer: 'Bu Maya', type: 'Rok', color: 'orange', startDate: '2025-06-20', endDate: '2025-06-25'},
            {id: 7, customer: 'Pak Tono', type: 'Kemeja', color: 'pink', startDate: '2025-06-24', endDate: '2025-06-30'},
            {id: 8, customer: 'Mbak Lina', type: 'Dress', color: 'cyan', startDate: '2025-06-28', endDate: '2025-07-03'}
        ];

        const monthNames = [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'
        ];

        function formatTanggalIndonesiaLong(date) {
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const d = typeof date === 'string' ? new Date(date) : date;
    return `${days[d.getDay()]}, ${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
}

        function toggleCalendar(type) {
            activeCalendar = type;
            document.getElementById('startCalendarDropdown').style.display = 'none';
            document.getElementById('endCalendarDropdown').style.display = 'none';
            const dropdown = document.getElementById(type === 'start' ? 'startCalendarDropdown' : 'endCalendarDropdown');
            dropdown.style.display = 'block';
            tempSelectedDate = (type === 'start' ? selectedStartDate : selectedEndDate) ? new Date(type === 'start' ? selectedStartDate : selectedEndDate) : null;
            renderCalendar(type);
        }

        function previousMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(activeCalendar);
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(activeCalendar);
        }

        function renderCalendar(type) {
            const monthYear = document.getElementById(type === 'start' ? 'startMonthYear' : 'endMonthYear');
            const daysContainer = document.getElementById(type === 'start' ? 'startDaysContainer' : 'endDaysContainer');
            monthYear.textContent = monthNames[currentDate.getMonth()] + ' ' + currentDate.getFullYear();
            daysContainer.innerHTML = '';

            const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
            const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
            const startDate = new Date(firstDay);
            const dayOfWeek = (firstDay.getDay() + 6) % 7;
            startDate.setDate(firstDay.getDate() - dayOfWeek);

            const dayElements = [];
            for (let i = 0; i < 42; i++) {
                const currentDay = new Date(startDate);
                currentDay.setDate(startDate.getDate() + i);

                const dayElement = document.createElement('div');
                dayElement.className = 'day';
                dayElement.textContent = currentDay.getDate();
                dayElement.dataset.date = currentDay.getFullYear() + '-' +
                    String(currentDay.getMonth() + 1).padStart(2, '0') + '-' +
                    String(currentDay.getDate()).padStart(2, '0');

                if (currentDay.getMonth() !== currentDate.getMonth()) {
                    dayElement.classList.add('other-month');
                }

                const today = new Date();
                if (currentDay.toDateString() === today.toDateString()) {
                    dayElement.classList.add('today');
                }

                if (tempSelectedDate && currentDay.toDateString() === tempSelectedDate.toDateString()) {
                    dayElement.classList.add('selected');
                }

                dayElement.addEventListener('click', function(e) {
                    e.stopPropagation();
                    daysContainer.querySelectorAll('.day.selected').forEach(el => {
                        el.classList.remove('selected');
                    });
                    dayElement.classList.add('selected');
                    tempSelectedDate = new Date(currentDay);
                    showOrderDetails(dayElement.dataset.date, dayElement);
                });

                daysContainer.appendChild(dayElement);
                dayElements.push(dayElement);
            }
            renderOrderLines(daysContainer, dayElements);
        }

        function renderOrderLines(daysContainer, dayElements) {
            daysContainer.querySelectorAll('.order-line').forEach(line => line.remove());
            orderData.forEach((order, orderIndex) => {
                const startDate = new Date(order.startDate);
                const endDate = new Date(order.endDate);
                const currentMonth = currentDate.getMonth();
                const currentYear = currentDate.getFullYear();

                if ((startDate.getFullYear() === currentYear && startDate.getMonth() === currentMonth) ||
                    (endDate.getFullYear() === currentYear && endDate.getMonth() === currentMonth) ||
                    (startDate <= new Date(currentYear, currentMonth, 1) && endDate >= new Date(currentYear, currentMonth + 1, 0))) {

                    let startIndex = -1, endIndex = -1;
                    dayElements.forEach((day, idx) => {
                        if (day.dataset.date === order.startDate) startIndex = idx;
                        if (day.dataset.date === order.endDate) endIndex = idx;
                    });
                    if (startIndex === -1) startIndex = 0;
                    if (endIndex === -1) endIndex = dayElements.length - 1;
                    if (startIndex <= endIndex) {
                        const startRow = Math.floor(startIndex / 7);
                        const endRow = Math.floor(endIndex / 7);
                        for (let row = startRow; row <= endRow; row++) {
                            const rowStartIndex = row * 7;
                            const rowEndIndex = Math.min(rowStartIndex + 6, dayElements.length - 1);
                            const lineStartIndex = Math.max(startIndex, rowStartIndex);
                            const lineEndIndex = Math.min(endIndex, rowEndIndex);
                            const startDay = dayElements[lineStartIndex];
                            const endDay = dayElements[lineEndIndex];
                            const line = document.createElement('div');
                            line.className = `order-line ${order.color}`;
                            line.title = `${order.customer} - ${order.type}`;
                            const startOffset = startDay.offsetLeft;
                            const endOffset = endDay.offsetLeft + endDay.offsetWidth;
                            const top = startDay.offsetTop + startDay.offsetHeight - 8 - (orderIndex % 4) * 4;
                            line.style.position = 'absolute';
                            line.style.left = startOffset + 'px';
                            line.style.width = (endOffset - startOffset) + 'px';
                            line.style.top = top + 'px';
                            daysContainer.appendChild(line);
                        }
                    }
                }
            });
        }

        function confirmDate(type) {
            if (tempSelectedDate) {
            if (type === 'start') {
                selectedStartDate = new Date(tempSelectedDate);
                document.getElementById('selectedStartDateText').textContent = formatTanggalIndonesiaLong(selectedStartDate);
            } else {
                selectedEndDate = new Date(tempSelectedDate);
                document.getElementById('selectedEndDateText').textContent = formatTanggalIndonesiaLong(selectedEndDate);
            }
            document.getElementById('displaySelectedDates').textContent =
                `Pengerjaan: ${selectedStartDate ? formatTanggalIndonesiaLong(selectedStartDate) : 'Belum dipilih'} - ` +
                `Penyelesaian: ${selectedEndDate ? formatTanggalIndonesiaLong(selectedEndDate) : 'Belum dipilih'}`;
            document.getElementById(type === 'start' ? 'startCalendarDropdown' : 'endCalendarDropdown').style.display = 'none';
        }
    }

        function getOrdersForDate(dateString) {
            return orderData.filter(order => {
                const orderStart = new Date(order.startDate);
                const orderEnd = new Date(order.endDate);
                const checkDate = new Date(dateString);
                return checkDate >= orderStart && checkDate <= orderEnd;
            });
        }

        function getOrderStatus(order, dateString) {
            const checkDate = new Date(dateString);
            const startDate = new Date(order.startDate);
            const endDate = new Date(order.endDate);
            if (checkDate.getTime() === startDate.getTime()) {
                return 'starting';
            } else if (checkDate.getTime() === endDate.getTime()) {
                return 'ending';
            } else {
                return 'ongoing';
            }
        }

        function showOrderDetails(dateString, dayElement) {
        const orders = getOrdersForDate(dateString);
        const modal = document.getElementById('orderDetailsModal');
        const modalTitle = document.getElementById('modalTitle');
        const orderDetailsList = document.getElementById('orderDetailsList');
        const date = new Date(dateString);
        modalTitle.textContent = `Pesanan - ${formatTanggalIndonesiaLong(date)}`;
        if (orders.length === 0) {
            orderDetailsList.innerHTML = '<div class="no-orders">Tidak ada pesanan pada tanggal ini</div>';
        } else {
            orderDetailsList.innerHTML = orders.map(order => {
                const status = getOrderStatus(order, dateString);
                const statusText = {
                    'starting': 'Mulai',
                    'ending': 'Selesai',
                    'ongoing': 'Dikerjakan'
                };
                return `
                    <div class="order-item ${order.color}">
                        <div class="order-customer">${order.customer}</div>
                        <div class="order-type">${order.type}</div>
                        <div class="order-duration">
                            ${formatTanggalIndonesiaLong(order.startDate)} - ${formatTanggalIndonesiaLong(order.endDate)}
                            <span class="order-status status-${status}">${statusText[status]}</span>
                        </div>
                    </div>
                `;
            }).join('');
        }
        modal.style.display = 'flex';
    }

        function closeOrderDetails() {
            document.getElementById('orderDetailsModal').style.display = 'none';
        }

        // Close calendar when clicking outside
        document.addEventListener('click', function(event) {
            const startPicker = document.querySelector('.date-picker:nth-child(1)');
            const endPicker = document.querySelector('.date-picker:nth-child(2)');
            const modal = document.getElementById('orderDetailsModal');
            if (!event.target.closest('.date-picker') && !modal.contains(event.target)) {
                document.getElementById('startCalendarDropdown').style.display = 'none';
                document.getElementById('endCalendarDropdown').style.display = 'none';
            }
            if (event.target === modal) {
                closeOrderDetails();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            renderCalendar('start');
        });

        setTimeout(() => {
            renderCalendar('start');
        }, 100);
    </script>
</body>
</html>
