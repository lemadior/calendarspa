function Layout ({ children }) {
    return (
        <>
            <header>
                This is Header
            </header>

            <main>
                { children }
            </main>
        </>
    );
}

export default Layout;
