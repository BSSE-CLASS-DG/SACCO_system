import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.net.Socket;

public class UpriseClient {

    public static void main(String[] args) {
        try {
            // Connect to the server
            Socket socket = new Socket("localhost", 3006);

            // Get the input and output streams for communication
            BufferedReader input = new BufferedReader(new InputStreamReader(socket.getInputStream()));
            PrintWriter output = new PrintWriter(socket.getOutputStream(), true);

            // Create a reader to read user input from the console
            BufferedReader consoleReader = new BufferedReader(new InputStreamReader(System.in));
           System.out.println("Welcome to Uprise Sacco Command Line Interface");
            // Prompt for command, username, and password
            System.out.println("Enter command, username, password, and additional details separated by spaces:");
            String[] inputTokens = consoleReader.readLine().split(" ");
            
            if (inputTokens.length < 3) {
                System.out.println("Invalid input format. Please try again.");
            }
            
            String command = inputTokens[0];
            String username = inputTokens[1];
            String password = inputTokens[2];

            switch (command) {
                case "login":
                    login(input, output, username, password);
                    break;
                case "exit":
                    System.out.println("Exiting Uprise Sacco client. Goodbye!");
                    break;
                default:
                    System.out.println("Invalid command. Please try again.");
                    break;
            }

            // Close the streams and socket
            consoleReader.close();
            input.close();
            output.close();
            socket.close();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    
    private static void login(BufferedReader input, PrintWriter output, String username, String password) throws IOException {
        BufferedReader consoleReader = new BufferedReader(new InputStreamReader(System.in));

       
            // Send login request to the server
            output.println("login " + username + " " + password);

            // Get server response
            String serverResponse = input.readLine();
            System.out.println("Server: " + serverResponse);

            // Check if login was successful
            if (serverResponse.equals("Login successful")) {
                System.out.println("Login successful");
                executeCommands(input, output);
            } else {
                System.out.println("Invalid username or password. enter your member number and phone number .");
                String [] refInputs = consoleReader.readLine().split(" ");
                requestReference(input, output,refInputs);
            }
        }
    

    private static void executeCommands(BufferedReader input, PrintWriter output) throws IOException {
        boolean continueExecution = true;
    
        while (continueExecution) {
            System.out.println("1. deposit (command receiptNumber  dateDeposited(year-month-day))");
            System.out.println("2. checkLoanStatus (command applicationNumber)");
            System.out.println("3. checkStatement (command dateFrom(year-month-day) dateTo(year-month-day)  ");
            System.out.println("4. requestLoan(command amount paymentPeriod memberMumber )");
            System.out.println("5. exit(command(to log_out and exit) )");
    
            System.out.println("Enter a command followed by its details:");
            BufferedReader consoleReader = new BufferedReader(new InputStreamReader(System.in));
            String[] inputTokens = consoleReader.readLine().split(" ");
            String commandName = inputTokens[0];
    
            switch (commandName) {
                case "deposit":
                    deposit(input, output, inputTokens);
                    break;
                case "requestLoan":
                    requestLoan(input, output, inputTokens);
                    break;
                case "checkStatement":
                    checkStatement(input, output, inputTokens);
                    break;
                case "checkLoanStatus":
                    checkLoanStatus(input, output, inputTokens);
                    break;
                case "exit":
                    System.out.println("Exiting Uprise Sacco client. Goodbye!");
                    continueExecution = false;
                    break;
                default:
                    System.out.println("Invalid command. Please try again.");
                    break;
            }
        }
    }
    
    

    private static void deposit(BufferedReader input, PrintWriter output, String[] commandTokens) throws IOException {
        // Extract additional details from commandTokens and perform deposit action
        // Send deposit request to the server
        output.println(String.join(" ", commandTokens));
    
        // Get server response
        String serverResponse = input.readLine();
        System.out.println("Server: " + serverResponse);
    }

     private static void requestReference(BufferedReader input, PrintWriter output, String[] refInputs) throws IOException {
        // Extract additional details from commandTokens and perform deposit action
        // Send deposit request to the server
        output.println(String.join(" ", refInputs));
    
        // Get server response
        String serverResponse = input.readLine();
        System.out.println("Server: " + serverResponse);
    }
    
    private static void requestLoan(BufferedReader input, PrintWriter output, String[] requestTokens) throws IOException {
        // Extract additional details from requestTokens and perform requestLoan action
        // Send requestLoan request to the server
        output.println(String.join(" ", requestTokens));
    
        // Get server response
        String serverResponse = input.readLine();
        System.out.println("Server: " + serverResponse);
    }
    

    private static void checkStatement(BufferedReader input, PrintWriter output, String[] commandTokens) throws IOException {
        // Extract additional details from commandTokens and perform checkStatement action
        // Send checkStatement request to the server
        output.println(String.join(" ", commandTokens));

        // Get server response
        String serverResponse = input.readLine();
        System.out.println("Server: " + serverResponse);
    }

    private static void checkLoanStatus(BufferedReader input, PrintWriter output, String[] loanStatusTokens) throws IOException {
        // Extract additional details from commandTokens and perform checkLoanStatus action
        // Send checkLoanStatus request to the server
      
        output.println(String.join(" ", loanStatusTokens));
    
        // Get server response
        String serverResponse = input.readLine();
        System.out.println("Server: " + serverResponse);
    
        // Check if the server response is "approved" and ask the user to enter a command accordingly
        if (serverResponse.equals("approved")) {
            acceptOrRejectLoan(input, output);
        } else {
            System.out.println("Your loan request is :" + serverResponse);
            // Handle other scenarios based on the server response if needed.
        }
    }

    private static void acceptOrRejectLoan( BufferedReader input, PrintWriter output) throws IOException{
         BufferedReader consoleReader = new BufferedReader(new InputStreamReader(System.in));
        System.out.println("Your loan request has been approved. Please enter the next command:");
        String command = consoleReader.readLine();
        output.println(command);
        
       String serverResponse = input.readLine();
        System.out.println("Server: " + serverResponse);
    }
}
