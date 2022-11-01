import MainLayout from "@/Layouts/MainLayout"
import ValueField from "@/Shared/PageComponent/Field/ValueField"
import Component from "@/Shared/PageComponent/Form/Component"

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
    return TodayDate == date;
}

const Timetable = ({schedule}) => {
    return <div className="schedules grid gap-4 grid-cols-3">
        {schedule.map((item) => {
            return (
                <div className='schedule br-1' key={item.id}>
                    <div className=' bg-orange-100 px-6 py-4'>
                        <h2 className='font-semibold text-lg mb-2'>{item.class_subject}</h2>
                        <span>{item.class_room}</span>
                        <span className="float-right">{item.teacher.name}</span>
                    </div>
                    
                    <table className="w-full table-padding-row">
                        <tbody>
                        {item.items.map(item => {
                            return <tr key={item.id} className={isToday(dn.date(item.session_date)) ? 'highlight' : ''}>
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
                        <Timetable schedule={props.schedules}></Timetable>
                    </div>
                </Component>
            </div>
        </MainLayout>
    )
}