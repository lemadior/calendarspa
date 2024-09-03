import { useState } from 'react';
// import { usePage } from '@inertiajs/react';
import Month from '../../Components/Month';
import MonthSelect from '../../Components/MonthSelect';
import YearSelect from '../../Components/YearSelect';

function Calendar ({ monthData, incomingDate }) {
    // const {
    //     component,
    //     props: {
    //         auth: {
    //             jwt_token: token
    //         }
    //     },
    // } = usePage();

    // console.log('Auth:', token);

    const currentDate = new Date();
    const [ iDate, setIDate ] = useState(incomingDate);
    const workDate = new Date(iDate);
    const [ month, setMonth ] = useState(workDate.getMonth());
    const [ year, setYear ] = useState(workDate.getFullYear());
    const [ mData, setMData ] = useState(monthData);
    const isCurrent = currentDate.getMonth() === workDate.getMonth() && currentDate.getFullYear() === workDate.getFullYear();
    const data = {
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
        const newDate = new Date();

        newDate.setFullYear(newYear);
        newDate.setMonth(newMonth);

        if ((new Date).getMonth() != newMonth) {
            // Here is setting date to 1st day of the month because if the month is not current one
            // The day date is not important
            newDate.setDate(1);
        }

        console.log(newDate.toLocaleString());

        // const fetchTokenAndData = async () => {

        try {
            // Get the API JWT token
            const tokenResponse = await fetch('/auth/get-user-token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'include'
            });

            if (!tokenResponse.ok) {
                throw new Error('Failed to fetch token');
            }

            const { token } = await tokenResponse.json();

            console.log('JWT Token:', token);

            const response = await fetch(`/api/admin/calendar?date=${encodeURIComponent(newDate.toISOString())}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });

            if (response.ok) {
                const { data } = await response.json();
                // console.log('Success:', result);

                setMData(data.monthData);
                setIDate(data.date);
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

            <div className="calendar_selection_container">
                <MonthSelect month={ month } onMonthChange={ handleMonthChange } />
                <YearSelect year={ year } onYearChange={ handleYearChange } />
            </div>

            <Month data={ data } />
        </>
    );
};

export default Calendar;
