package Timecard;

import javax.ws.rs.core.Application;
import java.util.Set;

@javax.ws.rs.ApplicationPath("resources")
public class ApplicationConfig extends Application {

    private Set<Class<?>> getRestResourceClasses(){
        Set<Class<?>> resources =
                new java.util.HashSet<>();

        resources.add(EmployeeService.class);
        return resources;
    }

    @Override
    public Set<Class<?>> getClasses(){
        return getRestResourceClasses();
    }

}