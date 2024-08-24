import { Link } from '@inertiajs/react';
import { useForm } from '@inertiajs/react';
import BigLogo from '../../Components/BigLogo';

function Register () {
    const { data, setData, post, errors, processing } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
    });

    function submit (e) {
        e.preventDefault();

        post(route('auth.register.post'));
    }

    return (
        <div className="auth_container">
            <h1 className='title'>Register New User</h1>

            <BigLogo />

            <div className="w-[360px] mx-auto">
                <form onSubmit={ submit } className="auth_form">
                    <input
                        type='text'
                        name='name'
                        value={ data.name }
                        placeholder="Your name"
                        className="auth_input"
                        onChange={ e => setData('name', e.target.value) }
                    />
                    { errors.name && <p className="validation_error">{ errors.name }</p> }

                    <input
                        type='email'
                        name='email'
                        value={ data.email }
                        placeholder="Your login / Email"
                        className="auth_input"
                        onChange={ e => setData('email', e.target.value) }
                    />
                    { errors.email && <p className="validation_error">{ errors.email }</p> }

                    <input
                        type='password'
                        name='password'
                        value={ data.password }
                        placeholder="Type pass here"
                        className="auth_input"
                        onChange={ e => setData('password', e.target.value) }
                    />
                    { errors.password && <p className="validation_error">{ errors.password }</p> }

                    <input
                        type='password'
                        name='password_confirmation'
                        value={ data.password_confirmation }
                        placeholder="Type pass for confirm"
                        className="auth_input"
                        onChange={ e => setData('password_confirmation', e.target.value) }
                    />
                    { errors.password_confirmation && <p className="validation_error">{ errors.password_confirmation }</p> }

                    <input type='submit' value='REGISTER' className="form_button" />
                </form>
            </div>

            <div className="login_underline">
                <p className="text-[12px] mt-2">
                    Just <Link href={ route('auth.login') } className="text-blue-700">login</Link> if You already
                    registered
                </p>
            </div>
        </div>
    );
}

export default Register;
