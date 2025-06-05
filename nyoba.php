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
            align-items: flex-start;    /* Angka di kiri */
            justify-content: flex-start;
            min-height: 56px;
            box-sizing: border-box;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            position: relative;
            overflow: hidden;
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

        .order-dot {
            width: 16px;
            height: 6px;
            border-radius: 3px;
            flex-shrink: 0;
        }

        .order-dot.red { background-color: #e53e3e; }
        .order-dot.blue { background-color: #3182ce; }
        .order-dot.green { background-color: #38a169; }
        .order-dot.yellow { background-color: #d69e2e; }
        .order-dot.purple { background-color: #805ad5; }
        .order-dot.orange { background-color: #dd6b20; }
        .order-dot.pink { background-color: #d53f8c; }
        .order-dot.cyan { background-color: #0987a0; }

        .day-number {
            font-size: 18px;
            font-weight: bold;
            margin: 6px 0 0 8px;       /* Jarak dari kiri atas */
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
    </style>
</head>
<body>
    <div class="container">
        <div class="form-section">
            <h2 style="margin-bottom: 20px; color: #2d3748;">Form Pengerjaan Pakaian</h2>
            
            <div class="form-group">
                <label>Pilih Tanggal Pengerjaan:</label>
                <div class="date-picker">
                    <div class="date-input" onclick="toggleCalendar()">
                        <span id="selectedDateText">Pilih Tanggal Pengerjaan</span>
                    </div>
                    
                    <div class="calendar-dropdown" id="calendarDropdown">
                        <div class="calendar-header">
                            <button class="nav-btn" onclick="previousMonth()">‹</button>
                            <span class="month-year" id="monthYear"></span>
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
                            <div class="days" id="daysContainer"></div>
                        </div>
                        
                        <button class="confirm-btn" onclick="confirmDate()">✓</button>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Tanggal Terpilih:</label>
                <div class="selected-date" id="displaySelectedDate">Belum dipilih</div>
            </div>
            
            <div class="form-group">
                <label>Keterangan Warna Penanda:</label>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; font-size: 12px; margin-top: 8px;">
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <div style="width: 8px; height: 4px; background: #e53e3e; border-radius: 2px;"></div>
                        <span>Kemeja/Blouse</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <div style="width: 8px; height: 4px; background: #3182ce; border-radius: 2px;"></div>
                        <span>Dress/Rok</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <div style="width: 8px; height: 4px; background: #38a169; border-radius: 2px;"></div>
                        <span>Celana</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <div style="width: 8px; height: 4px; background: #d69e2e; border-radius: 2px;"></div>
                        <span>Jaket/Outer</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentDate = new Date();
        let selectedDate = null;
        let tempSelectedDate = null;

        // Data pesanan contoh dengan rentang tanggal
        const orderData = [
            {
                id: 1,
                customer: 'Mas Amba',
                type: 'Kemeja',
                color: 'red',
                startDate: '2025-06-01',
                endDate: '2025-06-11'
            },
            {
                id: 2,
                customer: 'Bu Sari',
                type: 'Dress',
                color: 'blue',
                startDate: '2025-06-03',
                endDate: '2025-06-08'
            },
            {
                id: 3,
                customer: 'Pak Budi',
                type: 'Celana',
                color: 'green',
                startDate: '2025-06-10',
                endDate: '2025-06-15'
            },
            {
                id: 4,
                customer: 'Mbak Rina',
                type: 'Blouse',
                color: 'yellow',
                startDate: '2025-06-12',
                endDate: '2025-06-18'
            },
            {
                id: 5,
                customer: 'Mas Doni',
                type: 'Jaket',
                color: 'purple',
                startDate: '2025-06-16',
                endDate: '2025-06-22'
            },
            {
                id: 6,
                customer: 'Bu Maya',
                type: 'Rok',
                color: 'orange',
                startDate: '2025-06-20',
                endDate: '2025-06-25'
            },
            {
                id: 7,
                customer: 'Pak Tono',
                type: 'Kemeja',
                color: 'pink',
                startDate: '2025-06-24',
                endDate: '2025-06-30'
            },
            {
                id: 8,
                customer: 'Mbak Lina',
                type: 'Dress',
                color: 'cyan',
                startDate: '2025-06-28',
                endDate: '2025-07-03'
            }
        ];

        const monthNames = [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'
        ];

        function toggleCalendar() {
            const dropdown = document.getElementById('calendarDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            
            if (dropdown.style.display === 'block') {
                renderCalendar();
            }
        }

        function previousMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        }

        function renderCalendar() {
            const monthYear = document.getElementById('monthYear');
            const daysContainer = document.getElementById('daysContainer');
            
            monthYear.textContent = monthNames[currentDate.getMonth()] + ' ' + currentDate.getFullYear();
            
            // Clear previous days
            daysContainer.innerHTML = '';
            
            // Get first day of month and number of days
            const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
            const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
            
            // Calculate start date (beginning of calendar grid)
            const startDate = new Date(firstDay);
            const dayOfWeek = (firstDay.getDay() + 6) % 7; // Convert Sunday=0 to Monday=0
            startDate.setDate(firstDay.getDate() - dayOfWeek);
            
            // Generate calendar days
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
                
                // Style days from other months
                if (currentDay.getMonth() !== currentDate.getMonth()) {
                    dayElement.classList.add('other-month');
                }
                
                // Highlight today
                const today = new Date();
                if (currentDay.toDateString() === today.toDateString()) {
                    dayElement.classList.add('today');
                }
                
                // Show selected date
                if (tempSelectedDate && currentDay.toDateString() === tempSelectedDate.toDateString()) {
                    dayElement.classList.add('selected');
                }
                
                // Add click event
                dayElement.addEventListener('click', function() {
                    // Remove previous selection
                    document.querySelectorAll('.day.selected').forEach(el => {
                        el.classList.remove('selected');
                    });
                    
                    // Select current day
                    dayElement.classList.add('selected');
                    tempSelectedDate = new Date(currentDay);
                });
                
                daysContainer.appendChild(dayElement);
                dayElements.push(dayElement);
            }
            
            // Add order lines
            renderOrderLines();
        }

        function renderOrderLines() {
            const daysContainer = document.getElementById('daysContainer');
            
            // Remove existing order lines
            document.querySelectorAll('.order-line').forEach(line => line.remove());
            
            orderData.forEach((order, orderIndex) => {
                const startDate = new Date(order.startDate);
                const endDate = new Date(order.endDate);
                
                // Check if order is in current month view
                const currentMonth = currentDate.getMonth();
                const currentYear = currentDate.getFullYear();
                
                if ((startDate.getFullYear() === currentYear && startDate.getMonth() === currentMonth) ||
                    (endDate.getFullYear() === currentYear && endDate.getMonth() === currentMonth) ||
                    (startDate <= new Date(currentYear, currentMonth, 1) && endDate >= new Date(currentYear, currentMonth + 1, 0))) {
                    
                    const startDateStr = order.startDate;
                    const endDateStr = order.endDate;
                    
                    const startElement = document.querySelector(`[data-date="${startDateStr}"]`);
                    const endElement = document.querySelector(`[data-date="${endDateStr}"]`);
                    
                    if (startElement || endElement) {
                        createOrderLine(order, orderIndex, startDateStr, endDateStr);
                    }
                }
            });
        }

        function createOrderLine(order, orderIndex, startDateStr, endDateStr) {
            const daysContainer = document.getElementById('daysContainer');
            const allDays = Array.from(daysContainer.querySelectorAll('.day'));
            
            let startIndex = -1;
            let endIndex = -1;
            
            // Find start and end indices
            allDays.forEach((day, index) => {
                if (day.dataset.date === startDateStr) startIndex = index;
                if (day.dataset.date === endDateStr) endIndex = index;
            });
            
            // If start is before calendar view, start from beginning
            if (startIndex === -1) {
                const startDate = new Date(startDateStr);
                const firstCalendarDate = new Date(allDays[0].dataset.date);
                if (startDate < firstCalendarDate) {
                    startIndex = 0;
                }
            }
            
            // If end is after calendar view, end at last day
            if (endIndex === -1) {
                const endDate = new Date(endDateStr);
                const lastCalendarDate = new Date(allDays[allDays.length - 1].dataset.date);
                if (endDate > lastCalendarDate) {
                    endIndex = allDays.length - 1;
                }
            }
            
            if (startIndex !== -1 && endIndex !== -1 && startIndex <= endIndex) {
                const startRow = Math.floor(startIndex / 7);
                const endRow = Math.floor(endIndex / 7);
                
                // Create lines for each row
                for (let row = startRow; row <= endRow; row++) {
                    const rowStartIndex = row * 7;
                    const rowEndIndex = Math.min(rowStartIndex + 6, allDays.length - 1);
                    
                    const lineStartIndex = Math.max(startIndex, rowStartIndex);
                    const lineEndIndex = Math.min(endIndex, rowEndIndex);
                    
                    const startDay = allDays[lineStartIndex];
                    const endDay = allDays[lineEndIndex];
                    
                    const line = document.createElement('div');
                    line.className = `order-line ${order.color}`;
                    line.title = `${order.customer} - ${order.type}`;
                    
                    // Calculate position
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

        function confirmDate() {
            if (tempSelectedDate) {
                selectedDate = new Date(tempSelectedDate);
                
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                
                const formattedDate = selectedDate.toLocaleDateString('id-ID', options);
                
                document.getElementById('selectedDateText').textContent = formattedDate;
                document.getElementById('displaySelectedDate').textContent = formattedDate;
                
                // Hide calendar
                document.getElementById('calendarDropdown').style.display = 'none';
            }
        }

        // Close calendar when clicking outside
        document.addEventListener('click', function(event) {
            const datePicker = document.querySelector('.date-picker');
            if (!datePicker.contains(event.target)) {
                document.getElementById('calendarDropdown').style.display = 'none';
            }
        });

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Set to June 2025 to show example data
            currentDate = new Date(2025, 5, 1); // Month is 0-indexed, so 5 = June
            renderCalendar();
        });

        // Also initialize immediately
        setTimeout(() => {
            currentDate = new Date(2025, 5, 1);
            renderCalendar();
        }, 100);
    </script>
</body>
</html>