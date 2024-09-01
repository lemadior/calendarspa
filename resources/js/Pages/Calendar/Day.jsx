import { Link } from '@inertiajs/react';
import { EVENT_TYPES, EVENT_STATUSES, getDuration } from '../../Utils/Utils';

function Day ({ data }) {
    const {
        date,
        day,
        events
    } = data;

    const eventDate = new Date(date);
    const currentDate = new Date();
    const isExpired = eventDate.setHours(0, 0, 0, 0) < currentDate.setHours(0, 0, 0, 0);

    const re = /-/gi;
    const dayDate = date.replace(re, '.');

    return (
        <>
            <div className="day_events_header">
                <h1 className="day_events_header_title">Scheduled Events on { dayDate }</h1>
                <div className="day_events_header_dayname">
                    { day }
                </div>
            </div>


            <div className="day_events_table_container">
                { !isExpired &&
                    <Link href={ route('admin.event.create', { id: events.length + 1, date, dayDate }) } className="day_events_add_new">Create New Event</Link>
                }
                <div className="day_events_table_header">
                    <div className="day_events_table_header_id">#</div>
                    <div className="day_events_table_header_title">Title</div>
                    <div className="day_events_table_header_time">Time</div>
                    <div className="day_events_table_header_duration">Duration</div>
                    <div className="day_events_table_header_type">Type</div>
                    <div className="day_events_table_header_description">Description</div>
                    <div className="day_events_table_header_status">Status</div>
                </div>
                { events.length &&
                    <div className="event_data">
                        { events.map((event, index) => {
                            const duration = getDuration(event.duration);
                            const durationMsg = duration === "3:00" ? 'h or more' : 'h';

                            return <div key={ index }>
                                <Link href={ route('admin.event.edit', { event: event.id, id: index + 1, dayDate, isExpired: isExpired }) } className="py-2 mb-2 bg-slate-50 flex flex-row flex-nowrap justify-between items-center">
                                    <div className="text-center w-[45px] font-bold">{ index + 1 }</div>
                                    <div className="text-center w-1/3">{ event.title }</div>
                                    <div className="text-center w-[100px]">{ event.start }</div>
                                    <div className="text-center w-[100px]">{ duration == "0" ? 'Unlimited' : `${duration}${durationMsg}` }</div>
                                    <div className='text-center font-bold w-[150px]'>{ EVENT_TYPES[ event.type_id - 1 ] }</div>
                                    <div className="text-center w-1/3">{ event.description }</div>
                                    <div className="text-center w-[120px]">{ EVENT_STATUSES[ event.status_id - 1 ] }</div>
                                </Link>
                            </div>;
                        }) }
                    </div>
                    ||
                    <p className='day_has_no_events'>This day hasn't any events yet</p>
                }
            </div>

        </>
    );
}

export default Day;
