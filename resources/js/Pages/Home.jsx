import BigLogo from '../Components/BigLogo';

function Home () {
    return (
        <>
            <h1 className='title'>Home Pages</h1>

            <div>
                <div>
                    <BigLogo />

                    <div className="w-[80%] mx-auto text-justify mb-4">

                        <p className="font-cursive">
                            The service is a web-based calendar application that allows users to manage
                            their
                            daily schedules efficiently. Users can add events to specific days, providing
                            details such as the event title, time, and description. Once events are created,
                            they can be viewed in a daily, weekly, or monthly format, offering a clear
                            overview
                            of the user's upcoming commitments. The service also enables users to edit or
                            delete
                            events as their schedules change, ensuring that the calendar remains up-to-date.
                        </p>
                    </div>
                    <div className="w-[80%] mx-auto text-justify mb-6">
                        <p className="font-cursive">
                            One of the key features of this service is its API, which allows developers to
                            integrate the calendar's functionality into other applications. Through the API,
                            events can be programmatically added, modified, or removed, providing a flexible
                            solution for various use cases. Whether it's for personal scheduling, team
                            coordination, or automated reminders, this calendar service offers a versatile
                            tool
                            for managing time effectively.
                        </p>

                    </div>
                </div>
            </div>
        </>
    );
}

export default Home;
