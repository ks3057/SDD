package Calculator;

public class CalculatorClient {

    public static void main(String[] args) {
        //create web service object
        Calculator calc = new Calculator();

        //specify port to use
        CalculatorSoap calcSoapPort = calc.getCalculatorSoap();

        System.out.println(calcSoapPort.add(4,4));
    }
}
