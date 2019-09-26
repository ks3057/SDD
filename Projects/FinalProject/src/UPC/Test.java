package UPC;

public class Test {

    public static void main(String[] args) {
        UPCService u = new UPCService();
        System.out.println(u.getCount());
        System.out.println(u.getDescription("0071860432157"));
        System.out.println(u.getUpcs("Cat Collar"));
//        System.out.println(u.getUpcs("Cat+Collar"));
    }



}
