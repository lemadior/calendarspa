function BigLogo ({ align = 'center' }) {

    const alignLogo = align === 'left'
        ? 'float-left'
        : align === 'right'
            ? 'float-right'
            : 'mx-auto';

    return <img src="/storage/images/BigLogo.png" className={ `h-64 ${alignLogo}` } alt="big logo" />;
}

export default BigLogo;
