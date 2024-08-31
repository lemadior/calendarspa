import { usePage } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import Footer from '@/Components/Footer';
import Header from '@/Components/Header';

function Layout ({ children }) {
    const {
        component,
        props: pageProps,
    } = usePage();

    const {
        flash: {
            success,
            error
        },
        auth: {
            user
        }
    } = pageProps;

    const [ successMsg, setSuccessMsg ] = useState(success);
    const [ errorMsg, setErrorMsg ] = useState(error);

    useEffect(() => {
        if (success) {
            setSuccessMsg(success);
        }

        if (error) {
            setErrorMsg(error);
        }

    }, [ success, error ]);

    setTimeout(() => {
        setSuccessMsg(null);
        setErrorMsg(null);
    }, 2000);
    // console.log('page', usePage());

    const headerProps = {
        successMsg,
        errorMsg,
        isHome: component === 'Home',
        isLogin: component === 'Auth/Login',
        isRegister: component === 'Auth/Register',
        isDayEvents: component == 'Calendar/Day',
        user
    };

    console.log(component, headerProps);
    return (
        <div className="body_block">
            <Header headerProps={ headerProps } />

            <main>
                { children }
            </main>

            <Footer />
        </div>
    );
}

export default Layout;
