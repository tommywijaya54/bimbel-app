import MainLayout from "@/Layouts/MainLayout"
import Component from "@/Shared/PageComponent/Form/Component"
import { useState } from "react"

const dn = {
    'date':(value)=>{
        return (new Date(value)).toLocaleDateString(locale.code,locale.dateFormat)
    },
    'time':(value)=>{
        return value.substring(0,5);
    }
}

const TodayDate = dn.date(new Date());
const isToday = (date) => {
    return TodayDate == date
}
const TodayTimetable = ({schedules}) => {
    return <>Today Timetable</>
}
const Timetable = ({schedules}) => {
    let todaySchedule = [];
    let nextSession = false;

    schedules.forEach(schedule => {
        schedule.items.forEach(item => {
            if(nextSession){
                item.next_schedule = true;
                todaySchedule.push({item,schedule});
                nextSession = false;
            }

            if(isToday(dn.date(item.session_date))){
                item.today = true;
                todaySchedule.push({item,schedule});
                nextSession = true;
            }
        })
    });

    return <>
        <div className="schedules grid grid-cols-1 gap-4 md:grid-cols-3">
            {schedules.map((schedule) => {
                return (
                    <div className='schedule br-1' key={schedule.id}>
                        <div className=' bg-orange-100 px-6 py-4'>
                            <h2 className='font-semibold text-lg mb-2'>{schedule.class_subject}</h2>
                            <span>{schedule.class_room}</span>
                            <span className="float-right">{schedule.teacher.name}</span>
                        </div>
                        
                        <table className="w-full table-padding-row">
                            <tbody>
                            {schedule.items.map(item => {
                                return <tr key={item.id} className={item.today ? 'highlight' : ''}>
                                    <td>{dn.date(item.session_date)}</td>
                                    <td className="text-right">{dn.time(item.session_start_time)}</td>
                                    <td className="text-right">{dn.time(item.session_end_time)}</td>
                                </tr>
                            })}
                            </tbody>
                        </table>
                    </div>
                )
            })}
        </div>
    </>
}

export default (props) => {
    return (
        <MainLayout
            {...props}
        > 
            <div className="w-full">
                <Component
                    header={
                        <h2 className="font-semibold text-xl text-gray-800 leading-tight">Timetable
                            <span className="float-right">{TodayDate}</span>
                        </h2>
                    }
                    className={'create-form no-padding'}
                >
                    <div className='grow p-6'>
                        <Timetable schedules={props.schedules}></Timetable>
                    </div>
                </Component>
            </div>
        </MainLayout>
    )
}