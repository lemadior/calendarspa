import Week from './Week';
import { DAYS_IN_WEEK } from '../Utils/Utils';

function Month ({ data }) {
    const {
        monthData,
        workDate,
        isCurrent
    } = data;

    const dayOfWorkDate = workDate.getDay();
    console.log('m IsCurrent', isCurrent);
    return (
        <div className='calendar_month'>
            <div className="calendar_month_header">
                {
                    DAYS_IN_WEEK.map((day, index) => {
                        const isDayCurrent = day === DAYS_IN_WEEK[ dayOfWorkDate ];
                        const dayHeaderType = isDayCurrent && isCurrent ? 'current' : 'common';

                        return <div key={ index } className={ `calendar__month_header-${dayHeaderType}` }>{ day }</div>;
                    })
                }
            </div>

            {
                monthData.map((week, index) => {
                    return <Week key={ index } weekData={ week } workDate={ workDate } />;
                })
            }
        </div>
    );
}

export default Month;
