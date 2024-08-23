import { Link } from '@inertiajs/react';

function Footer () {
    return (
        <footer>
            <div className="footer_container">
                <div>
                    <p>© 2009-2024 All rights reserved</p>
                </div>

                <div>
                    <nav>
                        <ul className="flex space-x-8">
                            <li><Link href={ route('admin.calendar.index') } className="hover:text-black">Calendar</Link></li>
                            <li><Link href="#" className="hover:text-black">Api documentation</Link></li>
                        </ul>
                    </nav>
                </div>

                <div>
                    <p>Design by Me</p>
                </div>
            </div>
        </footer>
    );
}

export default Footer;
