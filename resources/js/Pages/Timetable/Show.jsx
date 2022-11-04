import MainLayout from "@/Layouts/MainLayout"
import Component from "@/Shared/PageComponent/Form/Component"
import Timetable from "@/Shared/PageComponent/Timetable";
const TodayDate = dn.date(new Date());

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