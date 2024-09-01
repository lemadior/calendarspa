import Day from './Day';
import { EVENT_TYPES } from '../Utils/Utils';

function Week (props) {
    const {
        weekData,
        workDate
    } = props;
    const today = new Date();

    return (
        <div className='calendar_week'>
            {
                weekData.map((day, index) => {
                    const isToday = day.today && today.getMonth() == workDate?.getMonth() && today.getFullYear() == workDate?.getFullYear();
                    const eventsCount = {
                        events: 0,
                        meetings: 0
                    };

                    if (day.events.length) {
                        day.events.forEach((event) => {
                            if (event.type_id === 2 || event.type_id === 3) {
                                eventsCount.meetings++;
                            } else {
                                eventsCount.events++;
                            }
                        });
                    }

                    const dayData = {
                        isEnabled: day.valid,
                        date: day.date,
                        workDate,
                        isCurrent: isToday,
                        eventsCount
                    };

                    return <Day key={ index } dayData={ dayData } />;
                })
            }
        </div>
    );
}

export default Week;
