import { Link, useForm } from '@inertiajs/react';
import Avatar from '@/Components/Avatar';

function Header (props) {
    const { post } = useForm();
    const {
        headerProps: {
            isHome,
            successMsg,
            errorMsg,
            isLogin,
            isRegister,
            isDayEvents,
            user
        }
    } = props;

    const logoLink = isHome ? '' : '/';
    const noLink = isHome ? 'no_link' : '';

    function submit (e) {
        e.preventDefault();

        post(route('auth.logout'));
    }

    return (
        <>
            <header>
                <div className="header_container">
                    <div className="header_logo">
                        <Link href={ logoLink } className={ noLink }><img src="/storage/images/SmallLogo.png" alt="logo" /></Link>

                        <span className="py-2">Calendar Event-Venues Aggregator</span>
                    </div>

                    <nav className="header_menu">
                        { ((isRegister || isHome) && !user) && <Link href={ route('auth.login') } className="nav-link">Login</Link> }
                        { ((isLogin || isHome) && !user) && <Link href={ route('auth.register') } className="nav-link">Register</Link> }

                        { user &&
                            <>
                                { isDayEvents &&
                                    <Link href={ route('admin.calendar.index') } className="hover:bg-gray-400 hover:text-white rounded-md">
                                        <img src="/storage/images/event.png" alt="calendar" className="h-11" />
                                    </Link>
                                }
                                <Avatar />
                                <form onSubmit={ submit }>
                                    <button className="nav-link outline-none">Logout</button>
                                </form>
                            </>
                        }
                    </nav>


                </div>
            </header>

            { successMsg && <div className='success'>{ successMsg }</div> }
            { errorMsg && <div className='error'>{ errorMsg }</div> }
        </>
    );
}

export default Header;
