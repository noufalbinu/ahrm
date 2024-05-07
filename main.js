import AirDatepicker from './node_moudules/air-datepicker';

import isWithinInterval  from 'date-fns/isWithinInterval';
import isEqual  from 'date-fns/isEqual';

const disabledDate = new Date('2023-07-13T00:00:00');

// Check if disabled date is in the range
const isDisabledDateIsInRange = ({date, datepicker}) => {
    const selectedDate = datepicker.selectedDates[0];
    if (selectedDate && datepicker.selectedDates.length === 1) {
        const sortedDates = [selectedDate, date].toSorted((a, b) => {
            if (a.getTime() > b.getTime()) {
                return 1;
            }
            return -1;
        })

        return (isWithinInterval(disabledDate, {
            start: sortedDates[0],
            end: sortedDates[1]
        }))
    }
}

new AirDatepicker('#el', {
    startDate: '2023-07-19',
    range: true,
    onBeforeSelect: ({date, datepicker}) => {
        // Dont allow user to select date, if disabled date is in the range
        return !isDisabledDateIsInRange({date, datepicker});
    },
    onFocus: ({date, datepicker}) => {
        if(isDisabledDateIsInRange({date, datepicker}) || isEqual(date, disabledDate)) {
            datepicker.$datepicker.classList.add('-disabled-range-')
        }else {
            datepicker.$datepicker.classList.remove('-disabled-range-')
        }
    },
    onRenderCell: ({date}) => {
        if(date.toLocaleDateString() === disabledDate.toLocaleDateString()) {
            return {
                disabled: true
            }
        }
    }
});