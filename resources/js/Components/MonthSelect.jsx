
import { MONTHS } from '../Utils/Utils';

function MonthSelect ({ month: monthNow, onMonthChange }) {
    return (
        <>
            <select
                name="month"
                id="month"
                className="month_select"
                defaultValue={ monthNow }
                onChange={ (e) => onMonthChange(e.target.value) }
            >
                { MONTHS.map((month, index) => {
                    return <option value={ index } key={ index + month }>{ month }</option>;
                }) }
            </select>
        </>
    );
}

export default MonthSelect;;
