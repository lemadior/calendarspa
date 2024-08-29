import Day from './Day';
import { EVENT_TYPES } from '../Utils/Utils';

function Week (props) {

    // console.log(props);

    const {
        weekData,
        workDate
    } = props;

    // const dayData = {
    //     isEnabled: true,
    //     date: 28,
    //     events: 0,
    //     meetings: 0
    // };

    // console.log(workDate?.getMonth(), workDate?.getFullYear());

    const today = new Date();

    return (
        <div className='calendar_week'>
            {
                weekData.map((day, index) => {
                    const isToday = day.today && today.getMonth() == workDate?.getMonth() && today.getFullYear() == workDate?.getFullYear();
                    const events = [];
                    const meetings = [];

                    if (day.events.length) {
                        day.events.forEach((event) => {
                            {/* if (!event.length) {
                                return;
                            } */}

                            if (event.type_id === 2 || event.type_id === 3) {
                                meetings.push(event);
                            } else {
                                events.push(event);
                            }
                        });
                    }

                    const dayData = {
                        isEnabled: day.valid,
                        date: day.date,
                        isCurrent: isToday,
                        events,
                        meetings
                    };

                    return < Day key={ index } dayData={ dayData } />;
                })
            }
        </div>
    );
}

export default Week;
