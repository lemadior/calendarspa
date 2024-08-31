import { useState } from 'react';
import Month from '../../Components/Month';
import MonthSelect from '../../Components/MonthSelect';
import YearSelect from '../../Components/YearSelect';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/react';

function Calendar ({ monthData, incomingDate }) {

    const currentDate = new Date();
    console.log('CD=', incomingDate);
    const [ iDate, setIDate ] = useState(incomingDate);
    const workDate = new Date(iDate);
    const [ month, setMonth ] = useState(workDate.getMonth());
    const [ year, setYear ] = useState(workDate.getFullYear());
    const [ mData, setMData ] = useState(monthData);



    // workDate.setFullYear(year);
    // workDate.setMonth(month);
    // workDate.setDate(currentDate.getDate());
    // console.log('Wdate: ' + workDate.toLocaleDateString());
    // const year = const year = date.getFullYear();
    // const month = currentDate.getMonth() + 1;
    // const workDate = currentDate;
    const isCurrent = currentDate.getMonth() === workDate.getMonth() && currentDate.getFullYear() === workDate.getFullYear();
    // console.log('C-isCurrent', isCurrent, currentDate.getDate(), workDate.getDate());
    const data = {
        // events,
        // types,
        monthData: mData,
        workDate,
        isCurrent
    };

    const handleMonthChange = (newMonth) => {
        console.log('newMonth', newMonth);
        setMonth(newMonth);

        fetchEvents(newMonth, year);
    };

    const handleYearChange = (newYear) => {
        setYear(newYear);
        fetchEvents(month, newYear);
    };

    const fetchEvents = async (newMonth, newYear) => {
        console.log('newMonth:newYear', newMonth, newYear);
        const newDate = new Date();
        newDate.setFullYear(newYear);
        newDate.setMonth(newMonth);
        console.log('month:year', month, year);
        if ((new Date).getMonth() != newMonth) {
            // Here is setting date to 1st day of the month because if the month is not current one
            // The day date is not important
            newDate.setDate(1);
        }

        console.log(newDate.toLocaleString());

        try {
            const response = await fetch(`/api/admin/calendar?date=${encodeURIComponent(newDate.toISOString())}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                }
            });

            if (response.ok) {
                const result = await response.json();
                console.log('Success:', result);

                setMData(result.monthData);
                setIDate(result.incomingDate);
            } else {
                console.error('Error:', response.statusText);
            }
        } catch (error) {
            console.error('There was an error!', error);
        }
    };

    return (
        <>
            <h1 className="title mb-4">Events dashboard</h1>
            <Link href={ route('admin.calendar.showday', { date: '2024-07-07', events: [ 1, 2, 3 ] }) }>Day Data</Link>
            <div className="calendar_selection_container">
                <MonthSelect month={ month } onMonthChange={ handleMonthChange } />
                <YearSelect year={ year } onYearChange={ handleYearChange } />
            </div>

            <Month data={ data } />
        </>
    );
}

export default Calendar;
