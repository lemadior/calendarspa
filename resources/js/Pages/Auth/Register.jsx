import { Link } from '@inertiajs/react';
import BigLogo from '../../Components/BigLogo';

function Register () {
    return (
        <div className="auth_container">
            <h1 className='title'>Register New User</h1>

            <BigLogo />

            <div className="w-[360px] mx-auto">
                <form name='myform' action='req.php' method='post' className="auth_form">
                    <input type='text' name='name' placeholder="Your name" className="auth_input" />
                    <input type='email' name='login' placeholder="Your login / Email" className="auth_input" />
                    <input type='password' name='pass' placeholder="Type pass here" className="auth_input" />
                    <input type='password' name='confirm' placeholder="Type pass for confirm" className="auth_input" />

                    <input type='submit' value='REGISTER' className="form_button" />
                </form>
            </div>
            <div className="login_underline">
                <p className="text-[12px] mt-2">Just <Link href={ route('auth.login') } className="text-blue-700">login</Link> if You already
                    registered</p>
            </div>
        </div>
    );
}

export default Register;
