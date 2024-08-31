import { Link, useForm } from '@inertiajs/react';
import {
    EVENT_TYPES,
    EVENT_STATUSES,
    EVENT_DURATIONS,
    getDuration
} from '../../Utils/Utils';

function Event ({ action, data: incomingData }) {
    const {
        event,
        id,
        date,
        dayDate
    } = incomingData;

    console.log(event);

    const { data, setData, post, patch, errors, processing } = useForm({
        title: action === 'edit' ? event?.title : '',
        start: action === 'edit' ? event?.start : '',
        description: action === 'edit' ? event?.description : '',
        duration: action === 'edit' ? getDuration(event?.duration) : '1',
        type_id: action === 'edit' ? event?.type_id : '1',
        status_id: action === 'edit' ? event?.status_id : '1'
    });

    function submit (e) {
        e.preventDefault();

        if (action === 'edit') {
            patch(route('admin.event.update', event.id));
        } else {
            post(route('admin.event.store', { date }));
        }
    }

    const submitTitle = action === 'edit' ? 'Update Event' : 'Create Event';

    return (
        <>
            <h1 className='day_events_header_title'>Event #{ id } on { dayDate }</h1>

            <form onSubmit={ submit } className='day_events_edit_form'>
                <label htmlFor='title'>Title</label>
                <input
                    type='text'
                    id='title'
                    name='title'
                    // defaultValue=''
                    value={ data.title }
                    onChange={ e => setData('title', e.target.value) }
                    className='day_events_edit_form_title'
                />
                { errors.title && <p className="validation_error">{ errors.title }</p> }

                <label htmlFor="start">Start Time</label>
                <input
                    type='time'
                    id='start'
                    name='start'
                    // defaultValue=''
                    value={ data.start }
                    onChange={ e => setData('start', e.target.value) }
                    className='day_events_edit_form_time'
                />
                { errors.start && <p className="validation_error">{ errors.start }</p> }

                <label htmlFor='duration'>Event duration</label>
                <select
                    name='duration'
                    id='duration'
                    className='day_events_edit_form_duration'
                    value={ data.duration }
                    onChange={ e => setData('duration', e.target.value) }
                // defaultValue='1'
                >
                    { Object.entries(EVENT_DURATIONS).map((entry, index) => {
                        return <option value={ entry[ 0 ] } key={ index }>{ entry[ 1 ] }</option>;
                    }) }
                </select>

                <label htmlFor='type_id'>Type of Event</label>
                <select
                    name='type_id'
                    id='type_id'
                    className='day_events_edit_form_type'
                    value={ data.type_id }
                    onChange={ e => setData('type_id', e.target.value) }
                // defaultValue='1'
                >
                    { EVENT_TYPES.map((type, index) => {
                        return <option value={ index + 1 } key={ index } >{ type }</option>;
                    }) }
                </select>

                <label htmlFor='status_id'>Status</label>
                <select
                    name='status_id'
                    id='status_id'
                    className='day_events_edit_form_status'
                    value={ data.status_id }
                    onChange={ e => setData('status_id', e.target.value) }
                // defaultValue='1'
                >
                    { EVENT_STATUSES.map((status, index) => {
                        return <option value={ index + 1 } key={ index } >{ status }</option>;
                    }) }
                </select>

                <label htmlFor="description">Description</label>
                <textarea
                    name="description"
                    id="description"
                    rows="5"
                    placeholder="Short description"
                    value={ data.description }
                    onChange={ e => setData('description', e.target.value) }
                    className="day_events_edit_form_description"
                ></textarea>

                <input type='submit' value={ submitTitle } className="day_events_edit_form_submit" />

                <Link as="button" type="button" onClick={ () => window.history.back() } className="day_events_edit_form_cancel">
                    Cancel
                </Link>


                { action === 'edit' &&
                    <Link
                        href={ route('admin.event.delete', event.id) } className="day_events_edit_form_delete"
                        as="button"
                        type="button"
                        method="delete"
                        onClick={ (e) => {
                            if (!confirm('Are you sure you want to delete this event?')) {
                                e.preventDefault();
                            }
                        } }
                    >
                        Delete Event
                    </Link>
                }

            </form>

        </>
    );
}

export default Event;
