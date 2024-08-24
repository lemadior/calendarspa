import BigLogo from '../../Components/BigLogo';
import { useForm } from '@inertiajs/react';

function Login () {
    // console.log(useForm());
    const { data, setData, post, errors, processing } = useForm({
        email: '',
        password: ''
    });

    function submit (e) {
        e.preventDefault();

        post(route('auth.login.post'));
    }

    return (
        <div className="auth_container">
            <h1 className='title'>Log Into The System</h1>

            <BigLogo />

            <div className="w-[360px] mx-auto">
                <form onSubmit={ submit } className="auth_form">
                    <input
                        type='email'
                        name='email'
                        value={ data.email }
                        onChange={ e => setData('email', e.target.value) }
                        placeholder="Your login / Email"
                        className="auth_input"
                    />
                    { errors.email && <p className="validation_error">{ errors.email }</p> }

                    <input
                        type='password'
                        name='password'
                        value={ data.password }
                        onChange={ e => setData('password', e.target.value) }
                        placeholder="Type pass here"
                        className="auth_input"
                    />
                    { errors.password && <p className="validation_error">{ errors.password }</p> }

                    <input type='submit' value='Log In' className="form_button" />
                </form>
            </div>
        </div>

    );
}

export default Login;
