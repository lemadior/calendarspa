const getYear = (delta) => {
    const currentYear = (new Date()).getFullYear();
    const endYear = currentYear + delta;
    let current = currentYear - delta;
    return () => {
        if (current > endYear) {
            return null;
        }

        return ++current;
    };
};

function getSelectOptions () {
    const options = [];
    const optionYear = getYear(5);

    let year;

    while ((year = optionYear()) !== null) {
        options.push(<option value={ year } key={ year }>{ year }</option>);
    }

    return options;
}

function YearSelect ({ year: yearNow, onYearChange }) {
    return (
        <>
            <select
                name="year"
                id="year"
                className="year_select"
                defaultValue={ yearNow }
                onChange={ (e) => onYearChange(e.target.value) }
            >
                { getSelectOptions() }
            </select>
        </>
    );
}

export default YearSelect;
