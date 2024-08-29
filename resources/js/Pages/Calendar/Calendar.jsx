import { useState } from 'react';
import Month from '../../Components/Month';
import MonthSelect from '../../Components/MonthSelect';
import YearSelect from '../../Components/YearSelect';
import { Inertia } from '@inertiajs/inertia';

function Calendar ({ monthData }) {

    const currentDate = new Date();

    const [ month, setMonth ] = useState(currentDate.getMonth());
    const [ year, setYear ] = useState(currentDate.getFullYear());
    const [ mData, setMData ] = useState(monthData);

    const workDate = new Date();
    workDate.setFullYear(year);
    workDate.setMonth(month);
    workDate.setDate(currentDate.getDate());
    console.log('Wdate: ' + workDate.toLocaleDateString());
    // const year = const year = date.getFullYear();
    // const month = currentDate.getMonth() + 1;
    // const workDate = currentDate;
    const isCurrent = currentDate.getMonth() === workDate.getMonth() && currentDate.getFullYear() === workDate.getFullYear();
    const data = {
        // events,
        // types,
        monthData: mData,
        workDate: isCurrent ? workDate : null
    };

    const handleMonthChange = (newMonth) => {
        setMonth(newMonth);
        fetchEvents(newMonth, year);
    };

    const handleYearChange = (newYear) => {
        setYear(newYear);
        fetchEvents(month, newYear);
    };

    const fetchEvents = async (selectedMonth, selectedYear) => {
        const newDate = new Date();
        newDate.setFullYear(selectedYear);
        newDate.setMonth(selectedMonth);

        if ((new Date).getMonth() != selectedMonth) {
            // Here is setting date to 1st day of the month because if the month is not current one
            // The day date is not important
            newDate.setDate(1);
        }
        // const dates = '2024-02-08T12:24:17.987Z';
        // const data = {
        //     date: newDate
        //     // Здесь можно добавить другие данные, если нужно
        // };
        //        // console.log('new adte: ' + encodeURIComponent(dates));
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
                setMData(result);
                // Здесь можно обновить состояние или перерисовать компонент на основе полученных данных
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
            <span>{ month } { year }</span>
            <div className="calendar_selection_container">
                <MonthSelect month={ month } onMonthChange={ handleMonthChange } />
                <YearSelect year={ year } onYearChange={ handleYearChange } />
            </div>

            <Month data={ data } />
        </>
    );
}

export default Calendar;
