package ua.com.m1995.client;

import java.awt.Dimension;
import java.awt.FlowLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;

public class ExceptionDialog {

	private String messageHeader = "Повідомлення про помилку:\n\n";
	private JTextArea jTextArea;
	
	public ExceptionDialog(Exception exception) {
		
		String message = exception.toString();
		
		final JFrame jFrame = new JFrame("Повідомлення про помилку...");
		jFrame.getContentPane().setLayout(new FlowLayout());
		jFrame.setSize(810,350);
		jFrame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		
		jTextArea = new JTextArea();
		jTextArea.setFont(jTextArea.getFont().deriveFont(14.0f));
		jTextArea.setLineWrap(true);
		jTextArea.setWrapStyleWord(true);
		
		jTextArea.setText(messageHeader + message);
		
		jTextArea.setPreferredSize(new Dimension(800,500));
		
		JScrollPane sp = new JScrollPane(jTextArea);
		sp.setPreferredSize(new Dimension(800,250));
		
		jFrame.getContentPane().add(sp);
		
		JButton jButton = new JButton("ЗАКРИТИ");
		jButton.addActionListener(
				new ActionListener() {
					public void actionPerformed(ActionEvent event) {
						jFrame.dispose();
					}
				}
		);
		
		
		jFrame.getContentPane().add(jButton);
		
		jFrame.setVisible(true);
	}
	
}
