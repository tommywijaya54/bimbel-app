import React, { useEffect, useState } from 'react';

const _dn = {
    day (date) {
        return date.toLocaleDateString(locale.code, { weekday: 'short' }); 
    },
    month (date) {
        return date.toLocaleDateString(locale.code, { month: 'short' }); 
    },
    long_month (date) {
        return date.toLocaleDateString(locale.code, { month: 'long' }); 
    }
}

const getMonth = (p_date) => {
    const year = p_date.getFullYear();
    const month = p_date.getMonth();

    const date = new Date(year, month, 1);
    const dates = [];
    while (date.getMonth() === month) {
        const d = new Date(date);
        d.currentmonth = true;
        dates.push(d);
        date.setDate(date.getDate() + 1);
    }
    return dates;
}

const completeCalenderDates = dates => {
    const addPrevMonth = (dates) => {
        const prevMonthDate = dates[0].getDay();
        for (let i = prevMonthDate; i > 1; i--) {
            const d = new Date(dates[0]);
            d.currentmonth = false;
            d.setDate(d.getDate() - 1);
            dates.unshift(d);
        }
        return dates;
    }

    const addNextMonth = (dates) =>{
        const nextMonthDate = 7 - dates[dates.length-1].getDay();
        for (let i = nextMonthDate; i > 0; i--) {
            const d = new Date(dates[dates.length-1]);
            d.currentmonth = false;
            d.setDate(d.getDate() + 1);
            dates.push(d);
        }
        return dates;
    }

    return addNextMonth(addPrevMonth(dates));
}

const ItemDate = ({date,selectDate}) => {
    const TodayDate = new Date();
    const isToday = date.toDateString() == TodayDate.toDateString();
    const isNewYear = (date.getDate() == 1 && date.getMonth() == 0);
    const isNewMonth = (date.getDate() == 1);
    return (
        <div
            onClick={e => selectDate(date)} 
            className={
                ('item px-2 py-1 ')+ 
                (date.currentmonth ? 'current-month ' : 'not-current-month ')+
                (date.getMonth()%2 ? 'even':'odd')+'_month '+
                (isToday ? ' today ':'')+
                (isNewYear ? ' new-year ' :'')+
                (date.selected ? ' selected ' : '')
            }>
                <div className='month-year'>
                {isNewYear ? 
                    <>{_dn.month(date) +' '+ date.getFullYear()}<br/></> : 
                    <div className={(isNewMonth ? 'new-month' : '') + ' month text-md'}>{_dn.month(date)}</div>
                }
                </div>
                <div className='date'>
                    {date.getDate()} 
                </div>
        </div>
    );
}

const setDateList = (InitialDate, NumberOfMonths) => {
    let List = [];
    let ProcessedDate = InitialDate;
    for(let i = 0; i < NumberOfMonths; i++){
        List = [...List, ...getMonth(ProcessedDate)];
        ProcessedDate.setMonth(ProcessedDate.getMonth() + 1);
    }
    let FirstDate = List[0];
    let LastDate = List[List.length-1];   
    List = completeCalenderDates(List);
    return {FirstDate,LastDate,List};
}

export default ({NumberOfMonths = 3}) => {
    let CurrentDate = new Date();
    let DateList = setDateList(CurrentDate, NumberOfMonths);
    
    const [FirstDate, setFirstDate] = useState(DateList.FirstDate);
    const [LastDate, setLastDate] = useState(DateList.LastDate);
    const [CalenderDateList, setCalenderDateList] = useState(DateList.List);
    const [SelectedDateList, setSelectedDateList] = useState([]);
    
    const setNewCalenderPanel = (newInitialDate, NumberOfMonths) => {
        DateList = setDateList(newInitialDate, NumberOfMonths);
        setFirstDate(DateList.FirstDate);
        setLastDate(DateList.LastDate);
        setCalenderDateList(DateList.List);
    }

    const selectDate = (date) => {
        const ds = date.toDateString();
        const NewCalenderList = CalenderDateList.map(d => {
            if (d.toDateString() == ds){
                d.selected = !d.selected;
            }
            return d;
        })
        
        setCalenderDateList(NewCalenderList);
    }

    const Panel = {
        prev(){
            let newInitialDate = new Date(FirstDate);
            newInitialDate.setMonth(newInitialDate.getMonth() - NumberOfMonths);
            setNewCalenderPanel(newInitialDate, NumberOfMonths);  
        },
        next(){
            let newInitialDate = new Date(LastDate);
            newInitialDate.setDate(newInitialDate.getDate() + 1);
            setNewCalenderPanel(newInitialDate, NumberOfMonths);
        }
    }
    
    const CalenderDate = ({list}) => {
        const DayNames = (list.slice(0, 7)).map(d => _dn.day(d));
        return (<div className='calender-panel'>
                    <div className='flex p-2 calender-nav'>
                        <button className='p-2 simple-button flex-none text-center w-14 bg-white' onClick={Panel.prev}>Last</button>
                        <div className='p-2 grow text-center text-lg'>{_dn.long_month(FirstDate)} {FirstDate.getFullYear()}</div>
                        <button className='p-2 simple-button flex-none text-center w-14 bg-white' onClick={Panel.next}>Next</button>
                    </div>
                    <div className='grid grid-cols-7 gap-2 calender p-2'>
                        {
                            DayNames.map((dn,i) => {
                                return <div key={i} className='day-name'>{dn}</div>
                            })
                        }
                        {
                            list.map((d,i) => {
                                return <ItemDate selectDate={selectDate} key={i} date={d}/>
                            })
                        }
                    </div>
                </div>
                );
    }

    return <div className='flex'>
        <div className='flex-none'>
            <CalenderDate list={CalenderDateList} />
        </div>
        <div className='grow'>
            {
                CalenderDateList.map((d,i) => {
                    return (
                        d.selected && 
                        <div key={i}>
                            {d.toLocaleDateString()}
                            {d.currentmonth && '   => Current Month'}
                            {d.selected && ' > Selected'}
                        </div>
                    )
                })
            }
        </div>
    </div>
};


/*

        
        const now = new Date();
        const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
        const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);
        return month;


*/